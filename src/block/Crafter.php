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

namespace pocketmine\block;

use pocketmine\block\tile\Crafter as CrafterTile;
use pocketmine\block\utils\Orientation;
use pocketmine\block\utils\OrientationFacing;
use pocketmine\block\utils\OrientationFacingTrait;
use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Item;
use pocketmine\math\Axis;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class Crafter extends Opaque implements OrientationFacing{
	use OrientationFacingTrait {
		describeBlockOnlyState as describeOrientation;
	}

	protected bool $crafting = false;
	protected bool $triggered = false;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w) : void{
		$this->describeOrientation($w);
		$w->bool($this->crafting);
		$w->bool($this->triggered);
	}

	/**
	 * @return bool
	 */
	public function isCrafting() : bool{
		return $this->crafting;
	}

	/**
	 * @param bool $crafting
	 */
	public function setCrafting(bool $crafting) : void{
		$this->crafting = $crafting;
	}

	public function isTriggered() : bool{
		return $this->triggered;
	}

	/** @return $this */
	public function setTriggered(bool $triggered) : Crafter{
		$this->triggered = $triggered;
		return $this;
	}

	/**
	 * @param BlockTransaction $tx
	 * @param Item             $item
	 * @param Block            $blockReplace
	 * @param Block            $blockClicked
	 * @param int              $face
	 * @param Vector3          $clickVector
	 * @param Player|null      $player
	 *
	 * @return bool
	 */
	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$orientation = Orientation::DOWN_EAST;
		if($player !== null){
			$pitch = $player->getLocation()->pitch;
			$primary = Facing::opposite($player->getHorizontalFacing());

			if($pitch > 80){
				$primary = Facing::UP;
			}elseif($pitch < -45){
				$primary = Facing::DOWN;
			}

			$secondary = Facing::axis($primary) === Axis::Y
				? Facing::opposite($player->getHorizontalFacing())
				: Facing::UP;

			$orientation = Orientation::getByFaces($primary, $secondary) ?? Orientation::DOWN_EAST;
		}

		$tx->addBlock($blockReplace->position, $this->setOrientation($orientation));
		return true;
	}

	/**
	 * @param Item        $item
	 * @param int         $face
	 * @param Vector3     $clickVector
	 * @param Player|null $player
	 * @param array       $returnedItems
	 *
	 * @return bool
	 */
	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		if ($player !== null) {
			$tile = $this->position->getWorld()->getTile($this->position);
			if ($tile instanceof CrafterTile) {
				$player->setCurrentWindow($tile->getRealInventory());
			}
		}
		return true;
	}
}
