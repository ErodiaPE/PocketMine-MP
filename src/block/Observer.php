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

use pocketmine\block\utils\AnyFacing;
use pocketmine\block\utils\AnyFacingTrait;
use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class Observer extends Opaque  implements AnyFacing{
	use AnyFacingTrait {
		describeBlockOnlyState as describeFacing;
	}

	private bool $powered = false;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w) : void{
		$this->describeFacing($w);
		$w->bool($this->powered);
	}

	/**
	 * @return bool
	 */
	public function isPowered() : bool{
		return $this->powered;
	}

	/**
	 * @param bool $powered
	 */
	public function setPowered(bool $powered) : void{
		$this->powered = $powered;
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
		if ($player !== null) {
			$x = abs($player->getLocation()->getFloorX() - $this->getPosition()->getX());
			$y = $player->getLocation()->getFloorY() - $this->getPosition()->getY();
			$z = abs($player->getLocation()->getFloorZ() - $this->getPosition()->getZ());
			if ($y > 0 && $x < 2 && $z < 2) {
				$this->setFacing(Facing::DOWN);
			} elseif ($y < -1 && $x < 2 && $z < 2) {
				$this->setFacing(Facing::UP);
			} else {
				$this->setFacing($player->getHorizontalFacing());
			}
		}

		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
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
		$this->powered = !$this->powered;
		return true;
	}
}
