<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\block\inventory\CrafterInventory;
use pocketmine\inventory\CallbackInventoryListener;
use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\World;

class Crafter extends Spawnable implements Container, Nameable{

	use ContainerTrait;
	use NameableTrait;

	private const TAG_CRAFTING_TICKS_REMAINING = "crafting_ticks_remaining";
	private const TAG_DISABLED_SLOTS = "disabled_slots";

	private CrafterInventory $inventory;
	private int $ticksRemaining = 0;
	private int $disabledSlots = 0;

	/**
	 * @param World   $world
	 * @param Vector3 $pos
	 */
	public function __construct(World $world, Vector3 $pos){
		parent::__construct($world, $pos);
		$this->inventory = new CrafterInventory($this->position);
		$this->inventory->getListeners()->add(new CallbackInventoryListener(
			function(Inventory $unused, int $slot, Item $unused2) : void{
				$this->setDirty();
			},
			function(Inventory $unused, array $oldItems) : void{
				$this->setDirty();
			}
		));
	}

	/**
	 * @param CompoundTag $nbt
	 *
	 * @return void
	 */
	public function readSaveData(CompoundTag $nbt) : void{
		$this->loadItems($nbt);
		$this->loadName($nbt);
		$this->disabledSlots = $nbt->getShort(self::TAG_DISABLED_SLOTS, 0);
		$this->ticksRemaining =  $nbt->getInt(self::TAG_CRAFTING_TICKS_REMAINING, 0);
	}

	/**
	 * @param CompoundTag $nbt
	 *
	 * @return void
	 */
	protected function writeSaveData(CompoundTag $nbt) : void{
		$this->saveItems($nbt);
		$this->saveName($nbt);

		$nbt->setShort(self::TAG_DISABLED_SLOTS, $this->disabledSlots);
		$nbt->setInt(self::TAG_CRAFTING_TICKS_REMAINING, $this->ticksRemaining);
	}

	protected function addAdditionalSpawnData(CompoundTag $nbt) : void{
		$this->saveName($nbt);
		$nbt->setShort(self::TAG_DISABLED_SLOTS, $this->disabledSlots);
		$nbt->setInt(self::TAG_CRAFTING_TICKS_REMAINING, $this->ticksRemaining);
	}

	/**
	 * @return void
	 */
	public function close() : void{
		if(!$this->closed){
			$this->inventory->removeAllViewers();

			parent::close();
		}
	}

	/**
	 * @return string
	 */
	public function getDefaultName() : string{
		return "Crafter";
	}

	/**
	 * @return CrafterInventory
	 */
	public function getInventory() : CrafterInventory{
		return $this->inventory;
	}

	/**
	 * @return CrafterInventory
	 */
	public function getRealInventory() : CrafterInventory{
		return $this->inventory;
	}

	/**
	 * @return int
	 */
	public function getTicksRemaining() : int{
		return $this->ticksRemaining;
	}

	/**
	 * @param int $ticksRemaining
	 */
	public function setTicksRemaining(int $ticksRemaining) : void{
		$this->ticksRemaining = $ticksRemaining;
		$this->setDirty();
	}

	/**
	 * @param int $slot
	 *
	 * @return bool
	 */
	public function isLocked(int $slot) : bool{
		return ($this->disabledSlots & (1 << $slot)) != 0;
	}

	/**
	 * @param int  $slot
	 * @param bool $state
	 *
	 * @return void
	 */
	public function setLocked(int $slot, bool $state = true) : void{
		$this->disabledSlots = !$state ? $this->disabledSlots ^ (1 << $slot) : $this->disabledSlots | (1 << $slot);
		$this->setDirty();
	}
}
