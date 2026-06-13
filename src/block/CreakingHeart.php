<?php

/*
 *
 * ____            _        _   __  __ _                  __  __ ____
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

use pocketmine\block\utils\CreakingHeartState;
use pocketmine\block\utils\PillarRotation;
use pocketmine\block\utils\PillarRotationTrait;
use pocketmine\block\utils\WoodType;
use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class CreakingHeart extends Opaque implements PillarRotation {
	use PillarRotationTrait;

	private bool $natural = false;
	private CreakingHeartState $creakingHeartState = CreakingHeartState::DORMANT;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w) : void{
		$w->bool($this->natural);
		$w->enum($this->creakingHeartState);
		$w->axis($this->axis);
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$this->axis = Facing::axis($face);
		$tx->addBlock($this->position, $this);
		$this->testAxis($tx);
		return true;
	}

	public function onNearbyBlockChange() : void{
		$tx = new BlockTransaction($this->position->getWorld());
		$this->testAxis($tx);
		$tx->apply();
	}

	protected function testAxis(BlockTransaction $tx) : void{
		$world = $this->position->getWorld();

		$newState = CreakingHeartState::DORMANT;
		foreach(Facing::ALL as $face){
			if(Facing::axis($face) === $this->axis){
				$sidePos = $this->position->getSide($face);
				$block = $tx->fetchBlock($sidePos) ?? $world->getBlock($sidePos);

				if($block instanceof Wood && $block->getWoodType()->equals(WoodType::PALE_OAK)){
					if($block->getAxis() !== $this->axis){
						$newState = CreakingHeartState::UPROOTED;
					}
				} else {
					$newState = CreakingHeartState::UPROOTED;
				}
			}
		}

		if($newState !== $this->creakingHeartState){
			$this->creakingHeartState = $newState;
			$tx->addBlock($this->position, $this);
		}
	}

	public function isActive() : bool{
		return $this->creakingHeartState !== CreakingHeartState::UPROOTED;
	}

	public function getLightLevel() : int{
		return $this->isActive() ? 15 : 0;
	}

	public function isNatural() : bool{
		return $this->natural;
	}

	public function setNatural(bool $natural) : self{
		$this->natural = $natural;
		return $this;
	}

	public function getCreakingHeartState() : CreakingHeartState{
		return $this->creakingHeartState;
	}

	public function setCreakingHeartState(CreakingHeartState $creakingHeartState) : self{
		$this->creakingHeartState = $creakingHeartState;
		return $this;
	}
}