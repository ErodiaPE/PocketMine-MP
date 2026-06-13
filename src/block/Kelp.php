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

use pocketmine\block\utils\Ageable;
use pocketmine\block\utils\AgeableTrait;
use pocketmine\item\Fertilizer;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\world\particle\BoneMealParticle;
use function mt_rand;

class Kelp extends Flowable implements Ageable {
	use AgeableTrait;

	private const MAX_AGE = 25;

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$world = $this->position->getWorld();
		$down = $world->getBlock($this->position->getSide(Facing::DOWN));

		if(!$blockReplace instanceof Water){
			return false;
		}

		$downId = $down->getTypeId();
		if(
			(!$down->isSolid() && !$down instanceof Kelp) ||
			$downId === VanillaBlocks::MAGMA()->getTypeId() ||
			$downId === VanillaBlocks::ICE()->getTypeId() ||
			$downId === VanillaBlocks::SOUL_SAND()->getTypeId()
		){
			return false;
		}

		if($down instanceof Kelp && $down->getAge() !== self::MAX_AGE){
			$tx->addBlock($down->position, $down->setAge(self::MAX_AGE));
		}

		$this->setAge(mt_rand(0, self::MAX_AGE - 1));
		$tx->addBlock($this->position, $this);

		return true;
	}

	public function ticksRandomly() : bool{
		return true;
	}

	public function onRandomTick() : void{
		$world = $this->position->getWorld();
		$up = $world->getBlock($this->position->getSide(Facing::UP));
		$down = $world->getBlock($this->position->getSide(Facing::DOWN));

		$downId = $down->getTypeId();
		if(
			!$up instanceof Water ||
			(!$down->isSolid() && !$down instanceof Kelp) ||
			$downId === VanillaBlocks::MAGMA()->getTypeId() ||
			$downId === VanillaBlocks::ICE()->getTypeId() ||
			$downId === VanillaBlocks::SOUL_SAND()->getTypeId()
		){
			$world->useBreakOn($this->position);
			return;
		}

		if(mt_rand(1, 100) <= 14){
			$this->grow();
		}
	}

	public function grow() : bool{
		$age = $this->getAge();
		if($age >= self::MAX_AGE){
			return false;
		}

		$world = $this->position->getWorld();
		$upPos = $this->position->getSide(Facing::UP);
		$up = $world->getBlock($upPos);

		if($up instanceof Water){
			$newKelp = VanillaBlocks::KELP()->setAge($age + 1);

			$tx = new BlockTransaction($world);
			$tx->addBlock($this->position, $this->setAge(self::MAX_AGE));
			$tx->addBlock($upPos, $newKelp);

			return $tx->apply();
		}

		return false;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		if(!$item instanceof Fertilizer){
			return false;
		}

		$world = $this->position->getWorld();

		$highestKelp = $this;
		$x = $this->position->x;
		$z = $this->position->z;

		for($y = $this->position->y + 1; $y < $world->getMaxY(); $y++) {
			$blockAbove = $world->getBlockAt($x, $y, $z);
			if($blockAbove instanceof Kelp) {
				$highestKelp = $blockAbove;
			} else {
				break;
			}
		}

		if($highestKelp->grow()){
			$world->addParticle($this->position, new BoneMealParticle());
			if($player !== null && !$player->isCreative()){
				$item->pop();
			}
			return true;
		}

		return false;
	}

	public function asItem() : Item{
		return VanillaItems::KELP();
	}
}
