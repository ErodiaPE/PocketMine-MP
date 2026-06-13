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

use pocketmine\block\utils\DirtType;
use pocketmine\item\Fertilizer;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\particle\BoneMealParticle;
use function abs;
use function mt_getrandmax;
use function mt_rand;

class MossBlock extends Opaque{
	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		if(!$item instanceof Fertilizer || $face !== Facing::UP){
			return false;
		}

		$world = $this->position->getWorld();

		$this->convertToMoss();
		$this->populateRegion();

		$world->addParticle(
			$this->position->add(0.5, 1.5, 0.5),
			new BoneMealParticle()
		);

		$item->pop();

		return true;
	}

	protected function canConvertToMoss(Block $block) : bool{
		return $block instanceof Grass ||
			($block instanceof Dirt && $block->getDirtType() === DirtType::NORMAL) ||
			($block instanceof Dirt && $block->getDirtType() === DirtType::ROOTED) ||
			$block instanceof Stone ||
			$block instanceof Mycelium ||
			$block instanceof Deepslate;
	}

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
						$world->setBlock($pos, VanillaBlocks::MOSS_BLOCK());
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
						$world->setBlock($pos, VanillaBlocks::MOSS_CARPET());
					}elseif($r < 0.53125){
						$world->setBlock($pos, VanillaBlocks::FERN());
					}elseif($r < 0.575){
						$world->setBlock($pos, VanillaBlocks::AZALEA());
					}elseif($r < 0.6){
						$world->setBlock($pos, VanillaBlocks::FLOWERING_AZALEA());
					}

					break;
				}
			}
		}
	}

	protected function canBePopulated(Vector3 $pos) : bool{
		$world = $this->position->getWorld();

		$floor = $world->getBlock($pos->down());
		$block = $world->getBlock($pos);

		return $floor->isSolid() &&
			!$floor instanceof MossCarpet &&
			$block instanceof Air;
	}

	protected function canGrowPlant(Vector3 $pos) : bool{
		$block = $this->position->getWorld()->getBlock($pos->down());

		return $block instanceof Grass
			|| $block instanceof Dirt
			|| $block instanceof Farmland
			|| $block instanceof Mycelium
			|| $block instanceof MossBlock;
	}
}
