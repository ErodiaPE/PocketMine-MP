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

namespace pocketmine\block\utils;

use pocketmine\data\runtime\RuntimeDataDescriber;

trait BrushableTrait{
	private bool $hanging = false;
	private int $progress = 0;

	public function isHanging() : bool{
		return $this->hanging;
	}

	public function setHanging(bool $hanging) : void{
		$this->hanging = $hanging;
	}

	public function getProgress() : int{
		return $this->progress;
	}

	public function setProgress(int $progress) : void{
		$this->progress = $progress;
	}

	protected function describeBlockOnlyState(RuntimeDataDescriber $w) : void
	{
		$w->bool($this->hanging);
		$w->boundedIntAuto(0, 3, $this->progress);
	}
}
