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
use pocketmine\block\utils\BlockEventHelper;
use pocketmine\block\utils\HorizontalFacing;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\block\utils\StaticSupportTrait;
use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\world\sound\BlockPlaceSound;

class LeafLitter extends Flowable implements Ageable, HorizontalFacing{
	use HorizontalFacingTrait;
	use StaticSupportTrait;
	use AgeableTrait;

	public const MAX_AGE = 7;

	/**
	 * @param RuntimeDataDescriber $w
	 *
	 * @return void
	 */
	protected function describeBlockOnlyState(RuntimeDataDescriber $w) : void{
		$w->facing($this->facing);
		$w->boundedIntAuto(0, 7, $this->age);
	}

	/**
	 * @param Block $block
	 *
	 * @return bool
	 */
	private function canBeSupportedAt(Block $block) : bool{
		$supportBlock = $block->getSide(Facing::DOWN);
		return $supportBlock->hasTypeTag(BlockTypeTags::DIRT) || $supportBlock->hasTypeTag(BlockTypeTags::MUD);
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
			$this->facing = Facing::opposite($player->getHorizontalFacing());
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
		if ($item->equals($this->asItem(), false, false)) {
			if ($this->age < 3) {
				if (BlockEventHelper::grow($this, VanillaBlocks::LEAF_LITTER()
					->setFacing($this->facing)
					->setAge($this->age + 1),
					$player
				)) {
					$item->pop();
					$this->position->getWorld()->addSound($this->position, new BlockPlaceSound($this));
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * @return bool
	 */
	public function canBeReplaced() : bool{
		return true;
	}

	public function getDrops(Item $item) : array{
		return [$this->asItem()->setCount($this->getAge())];
	}
}