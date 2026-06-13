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

use pocketmine\block\utils\Attachment;
use pocketmine\block\utils\AttachmentTrait;
use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\HorizontalFacing;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class Grindstone extends Opaque implements HorizontalFacing{
	use AttachmentTrait;
	use HorizontalFacingTrait;
	use FacesOppositePlacingPlayerTrait;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w) : void{
		$w->horizontalFacing($this->facing);
		$this->describeAttachment($w);
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player !== null){
			if (!$blockClicked instanceof Air && $blockClicked->canBeReplaced()) {
				$face = Facing::UP;
			}
			switch ($face) {
				case Facing::UP: {
					$this->facing = Facing::opposite($player->getHorizontalFacing());
					$this->setAttachment(Attachment::STANDING);
					break;
				}
				case Facing::DOWN: {
					$this->facing = Facing::opposite($player->getHorizontalFacing());
					$this->setAttachment(Attachment::HANGING);
					break;
				}
				default: {
					$this->facing = $face;
					$this->setAttachment(Attachment::SIDE);
					break;
				}
			}
		}
		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}
}
