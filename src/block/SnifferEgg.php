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

use pocketmine\block\utils\CrackedState;
use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class SnifferEgg extends Transparent
{
	private CrackedState $cracks = CrackedState::NO_CRACKS;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w): void
	{
		$w->enum($this->cracks);
	}

	/**
	 * @return CrackedState
	 */
	public function getCracks() : CrackedState{
		return $this->cracks;
	}

	/**
	 * @param CrackedState $cracks
	 *
	 * @return SnifferEgg
	 */
	public function setCracks(CrackedState $cracks) : SnifferEgg{
		$this->cracks = $cracks;
		return $this;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		$this->position->getWorld()->setBlock($this->position, $this->setCracks($this->getCracks()->next()));
		return true;
	}
}