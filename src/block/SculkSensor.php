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
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class SculkSensor extends Transparent{
	protected int $phase = 0;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w) : void
	{
		$w->boundedIntAuto(0, 2, $this->phase);
	}

	public function getPhase() : int
	{
		return $this->phase;
	}

	public function setPhase(int $phase) : static
	{
		$this->phase = $phase;
		return $this;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		$this->position->getWorld()->setBlock($this->position, $this->setPhase(($this->getPhase() + 1) % 3));
		return true;
	}

	public function getLightLevel() : int
	{
		return 1;
	}
}
