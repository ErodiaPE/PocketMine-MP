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

class TrialSpawner extends MonsterSpawner{
	private bool $ominous = false;
	private int $state = 0;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w) : void{
		$w->bool($this->ominous);
		$w->boundedIntAuto(0, 5, $this->state);
	}

	/**
	 * @return bool
	 */
	public function isOminous() : bool{
		return $this->ominous;
	}

	/**
	 * @param bool $ominous
	 */
	public function setOminous(bool $ominous) : void{
		$this->ominous = $ominous;
	}

	/**
	 * @return int
	 */
	public function getState() : int{
		return $this->state;
	}

	/**
	 * @param int $state
	 */
	public function setState(int $state) : void{
		$this->state = $state;
	}
}