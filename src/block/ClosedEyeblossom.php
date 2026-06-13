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

use pocketmine\block\utils\BlockEventHelper;
use pocketmine\world\World;

class ClosedEyeblossom extends Flower{

	public function ticksRandomly() : bool{
		return true;
	}

	public function onRandomTick() : void{
		$world = $this->position->getWorld();

		if($world->getTimeOfDay() < World::TIME_NIGHT){
			BlockEventHelper::grow($this, VanillaBlocks::CLOSED_EYEBLOSSOM(), null);
			$this->rescheduleNearby();
		}
	}

	private function rescheduleNearby() : void{
		$world = $this->position->getWorld();

		for($x = -3; $x <= 3; $x++){
			for($y = -2; $y <= 2; $y++){
				for($z = -3; $z <= 3; $z++){

					$pos = $this->position->add($x, $y, $z);
					$block = $world->getBlock($pos);

					if($block instanceof ClosedEyeblossom || $block instanceof OpenEyeblossom){
						$world->scheduleDelayedBlockUpdate($pos, 1);
					}
				}
			}
		}
	}
}
