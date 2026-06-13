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

use pocketmine\math\Vector3;
use function mt_rand;

class PaleMossBlock extends MossBlock{
	protected function convertToMoss() : void{
		$world = $this->position->getWorld();

		for($x = -3; $x <= 3; $x++){
			for($z = -3; $z <= 3; $z++){
				for($y = 5; $y >= -5; $y--){

					$pos = $this->position->add($x, $y, $z);
					$block = $world->getBlock($pos);

					if(
						$this->canConvertToMoss($block) &&
						(mt_rand() / mt_getrandmax() < 0.6 ||
							(abs($x) < 3 && abs($z) < 3))
					){
						$world->setBlock($pos, VanillaBlocks::PALE_MOSS_BLOCK());
						break;
					}
				}
			}
		}
	}

	protected function populateRegion() : void{
		$world = $this->position->getWorld();

		for($x = -3; $x <= 3; $x++){
			for($z = -3; $z <= 3; $z++){
				for($y = 5; $y >= -5; $y--){

					$pos = $this->position->add($x, $y, $z);

					if(!$this->canBePopulated($pos)){
						continue;
					}

					if(!$this->canGrowPlant($pos)){
						break;
					}

					$r = mt_rand() / mt_getrandmax();

					if($r < 0.3125){
						$world->setBlock($pos, VanillaBlocks::TALL_GRASS());
					}elseif($r < 0.46875){
						$world->setBlock($pos, VanillaBlocks::PALE_MOSS_CARPET());
					}elseif($r < 0.53125){
						$world->setBlock($pos, VanillaBlocks::FERN());
					}

					break;
				}
			}
		}
	}

	protected function canGrowPlant(Vector3 $pos) : bool{
		$block = $this->position->getWorld()->getBlock($pos->down());

		return $block instanceof Grass
			|| $block instanceof Dirt
			|| $block instanceof Farmland
			|| $block instanceof Mycelium
			|| $block instanceof PaleMossBlock;
	}
}
