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

use pocketmine\block\tile\CopperGolem as CopperGolemTile;
use pocketmine\block\utils\CopperGolemPose;
use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\HorizontalFacing;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class CopperGolem extends Transparent implements HorizontalFacing{
	use HorizontalFacingTrait;
	use FacesOppositePlacingPlayerTrait;

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		if ($player !== null && $item->isNull()) {
			$tile = $this->position->getWorld()->getTile($this->position);
			if ($tile instanceof CopperGolemTile) {
				$tile->setPose(match($tile->getPose()){
					CopperGolemPose::STANDING => CopperGolemPose::SITTING,
					CopperGolemPose::SITTING => CopperGolemPose::RUNNING,
					CopperGolemPose::RUNNING => CopperGolemPose::STAR,
					CopperGolemPose::STAR => CopperGolemPose::STANDING,
				});
				return true;
			}
		}
		return false;
	}
}