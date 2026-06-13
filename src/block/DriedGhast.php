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

use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\HorizontalFacing;
use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class DriedGhast extends Transparent implements HorizontalFacing
{
	use FacesOppositePlacingPlayerTrait {
		describeBlockOnlyState as describeFacingState;
	}

	protected int $hydratationLevel = 0;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w) : void
	{
		$this->describeFacingState($w);
		$w->boundedIntAuto(0, 3, $this->hydratationLevel);
	}

	public function getHydratationLevel() : int
	{
		return $this->hydratationLevel;
	}

	public function setHydratationLevel(int $hydratationLevel) : self
	{
		$this->hydratationLevel = $hydratationLevel;
		return $this;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		$this->position->getWorld()->setBlock($this->position, $this->setHydratationLevel(($this->getHydratationLevel() + 1) % 3));
		return true;
	}
}
