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

use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\item\Shears;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use function count;

class PaleHangingMoss extends Flowable {

	private bool $tip = false;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w) : void{
		$w->bool($this->tip);
	}

	public function isTip() : bool{
		return $this->tip;
	}

	/**
	 * @return $this
	 */
	public function setTip(bool $tip) : self{
		$this->tip = $tip;
		return $this;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$world = $this->position->getWorld();
		$up = $world->getBlock($this->position->getSide(Facing::UP));

		if(!$up->isSolid() && !$up instanceof PaleHangingMoss){
			return false;
		}

		$this->tip = true;
		$tx->addBlock($this->position, $this);

		$this->updateStructure($tx);
		return true;
	}

	private function updateStructure(BlockTransaction $tx) : void{
		$world = $this->position->getWorld();

		$basePos = $this->position;
		while(($prev = $tx->fetchBlock($basePos->getSide(Facing::UP)) ?? $world->getBlock($basePos->getSide(Facing::UP))) instanceof PaleHangingMoss){
			$basePos = $basePos->getSide(Facing::UP);
		}

		$currentPos = $basePos;
		/** @var PaleHangingMoss[] $columnBlocks */
		$columnBlocks = [];

		while(($block = $tx->fetchBlock($currentPos) ?? $world->getBlock($currentPos)) instanceof PaleHangingMoss){
			$columnBlocks[] = $block;
			$currentPos = $currentPos->getSide(Facing::DOWN);
		}

		$totalLength = count($columnBlocks);

		foreach($columnBlocks as $index => $b){
			$updatedBlock = clone $b;
			$isLast = ($index === $totalLength - 1);

			$updatedBlock->setTip($isLast);
			$tx->addBlock($updatedBlock->position, $updatedBlock);
		}
	}

	public function onNearbyBlockChange() : void{
		$world = $this->position->getWorld();
		$up = $world->getBlock($this->position->getSide(Facing::UP));

		if(!$up->isSolid() && !$up instanceof PaleHangingMoss){
			$world->useBreakOn($this->position);
		}
	}

	public function onBreak(Item $item, ?Player $player = null, array &$returnedItems = []) : bool{
		$world = $this->position->getWorld();

		$result = parent::onBreak($item, $player, $returnedItems);

		$upPos = $this->position->getSide(Facing::UP);
		$upBlock = $world->getBlock($upPos);

		if($upBlock instanceof PaleHangingMoss){
			$tx = new BlockTransaction($world);
			$upBlock->updateStructure($tx);
			$tx->apply();
		}

		return $result;
	}

	/**
	 * @return array|Item[]
	 */
	public function getDrops(Item $item) : array{
		if($item instanceof Shears || $item->hasEnchantment(VanillaEnchantments::SILK_TOUCH())){
			return [$this->asItem()];
		}
		return [];
	}
}
