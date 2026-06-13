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

namespace pocketmine\block\tile;

use pocketmine\block\utils\CopperGolemPose;
use pocketmine\nbt\tag\CompoundTag;

class CopperGolem extends Spawnable{
	public const TAG_IS_MOVABLE = "isMovable";
	public const TAG_POSE = "Pose";

	private CopperGolemPose $pose = CopperGolemPose::STANDING;
	private bool $isMovable = false;

	/**
	 * @return CopperGolemPose
	 */
	public function getPose() : CopperGolemPose{
		return $this->pose;
	}

	/**
	 * @param CopperGolemPose $pose
	 */
	public function setPose(CopperGolemPose $pose) : void{
		$this->pose = $pose;
		$this->setDirty();
	}

	/**
	 * @return bool
	 */
	public function isMovable() : bool{
		return $this->isMovable;
	}

	/**
	 * @param bool $isMovable
	 */
	public function setIsMovable(bool $isMovable) : void{
		$this->isMovable = $isMovable;
		$this->setDirty();
	}

	public function readSaveData(CompoundTag $nbt) : void{
		$this->pose = CopperGolemPose::from($nbt->getInt(self::TAG_POSE, 0));
		$this->isMovable = (bool)$nbt->getByte(self::TAG_IS_MOVABLE, 0);
	}

	/**
	 * @param CompoundTag $nbt
	 *
	 * @return void
	 */
	protected function writeSaveData(CompoundTag $nbt) : void{
		$nbt->setInt(self::TAG_POSE, $this->pose->value);
		$nbt->setByte(self::TAG_IS_MOVABLE, (int)$this->isMovable);
	}

	/**
	 * @param CompoundTag $nbt
	 *
	 * @return void
	 */
	protected function addAdditionalSpawnData(CompoundTag $nbt) : void{
		$nbt->setInt(self::TAG_POSE, $this->pose->value);
		$nbt->setByte(self::TAG_IS_MOVABLE, (int)$this->isMovable);
	}
}
