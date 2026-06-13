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

use pocketmine\block\utils\PaleMossCarpetSide;

class PaleMossCarpet extends MossCarpet{

	/** @var PaleMossCarpetSide[] */
	private array $carpetSides = [];
	private bool $upperBit = false;

	/**
	 * @param int $facing
	 *
	 * @return PaleMossCarpetSide
	 */
	public function getCarpetSide(int $facing) : PaleMossCarpetSide{
		return $this->carpetSides[$facing] ?? PaleMossCarpetSide::NONE;
	}

	/**
	 * @param int                $facing
	 * @param PaleMossCarpetSide $side
	 *
	 * @return void
	 */
	public function setCarpetSide(int $facing, PaleMossCarpetSide $side) : void{
		$this->carpetSides[$facing] = $side;
	}

	/**
	 * @return bool
	 */
	public function isUpperBit() : bool{
		return $this->upperBit;
	}

	/**
	 * @param bool $upperBit
	 */
	public function setUpperBit(bool $upperBit) : void{
		$this->upperBit = $upperBit;
	}
}
