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

use pocketmine\block\tile\Shelf as ShelfTile;
use pocketmine\block\utils\HorizontalFacing;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class Shelf extends Transparent implements HorizontalFacing{
	use HorizontalFacingTrait {
		describeBlockOnlyState as describeFacing;
	}

	public const TYPE_UNCONNECTED = 0;
	public const TYPE_RIGHT = 1;
	public const TYPE_CENTER = 2;
	public const TYPE_LEFT = 3;

	private int $shelfType = self::TYPE_UNCONNECTED;
	private bool $powered = false;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w) : void
	{
		$this->describeFacing($w);
		$w->boundedIntAuto(0, 3, $this->shelfType);
		$w->bool($this->powered);
	}

	public function getShelfType() : int{
		return $this->shelfType;
	}

	public function setShelfType(int $shelfType) : void{
		$this->shelfType = $shelfType;
	}

	public function isPowered() : bool{
		return $this->powered;
	}

	public function setPowered(bool $powered) : void{
		$this->powered = $powered;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player !== null){
			$this->setFacing(Facing::opposite($player->getHorizontalFacing()));
		}
		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		if($player === null || $player->isSneaking()){
			return false;
		}

		$tile = $this->position->getWorld()->getTile($this->position);
		if(!$tile instanceof ShelfTile){
			return false;
		}

		$slot = $this->calculateSlot($clickVector);
		$inv = $tile->getInventory();

		$current = $inv->getItem($slot);
		$hand = $player->getInventory()->getItemInHand();

		if(!$player->isCreative()){
			$player->getInventory()->setItemInHand($current);
		}

		$inv->setItem($slot, $hand);
		$tile->setDirty();
		return true;
	}

	private function calculateSlot(Vector3 $click) : int{
		$facing = $this->getFacing();

		$dir = Facing::rotateY($facing, false);
		[$x, , $z] = Facing::OFFSET[$dir];

		$distance = ($click->x * $x) + ($click->z * $z);

		if($distance < 0){
			$distance += 1;
		}

		return $distance < (1 / 3)
			? 0
			: ($distance < (2 / 3) ? 1 : 2);
	}

}
