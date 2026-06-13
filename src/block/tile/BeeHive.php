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

use pocketmine\block\utils\Occupant;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;

class BeeHive extends Spawnable{
	public const TAG_OCCUPANTS = "Occupants";
	public const TAG_ACTOR_IDENTIFIER = "ActorIdentifier";
	public const TAG_SAVE_DATA = "SaveData";
	public const TAG_TICKS_LEFT_TO_STAY = "TicksLeftToStay";
	public const TAG_SHOULD_SPAWN_BEES = "ShouldSpawnBees";

	/** @var Occupant[] */
	private array $occupants = [];
	private bool $shouldSpawnBees = false;

	/**
	 * @return bool
	 */
	public function isShouldSpawnBees() : bool{
		return $this->shouldSpawnBees;
	}

	/**
	 * @param bool $shouldSpawnBees
	 */
	public function setShouldSpawnBees(bool $shouldSpawnBees) : void{
		$this->shouldSpawnBees = $shouldSpawnBees;
	}

	/**
	 * @return array
	 */
	public function getOccupants() : array{
		return $this->occupants;
	}

	/**
	 * @param array $occupants
	 */
	public function setOccupants(array $occupants) : void{
		$this->occupants = $occupants;
	}

	public function addOccupant(Occupant $occupant) : void{
		$this->occupants[] = $occupant;
	}

	public function readSaveData(CompoundTag $nbt) : void{
		$this->occupants = [];
		foreach($nbt->getListTag(self::TAG_OCCUPANTS)->getValue() as $tag){
			/** @var CompoundTag $tag */
			$this->addOccupant(Occupant::fromNBT($tag));
		}

		$this->shouldSpawnBees = (bool)$nbt->getByte(self::TAG_SHOULD_SPAWN_BEES, 0);
	}

	/**
	 * @param CompoundTag $nbt
	 *
	 * @return void
	 */
	protected function writeSaveData(CompoundTag $nbt) : void{
		$nbt->setTag(self::TAG_OCCUPANTS, new ListTag(array_map(fn(Occupant $occupant) => $occupant->saveNBT(), $this->occupants)));
		$nbt->setByte(self::TAG_SHOULD_SPAWN_BEES, (int)$this->shouldSpawnBees);
	}

	/**
	 * @param CompoundTag $nbt
	 *
	 * @return void
	 */
	protected function addAdditionalSpawnData(CompoundTag $nbt) : void{
		$nbt->setTag(self::TAG_OCCUPANTS,
			CompoundTag::create()
				->setTag(self::TAG_OCCUPANTS, new ListTag(array_map(fn(Occupant $occupant) => $occupant->saveNBT(), $this->occupants)))
		);
		$nbt->setByte(self::TAG_SHOULD_SPAWN_BEES, (int)$this->shouldSpawnBees);
	}
}
