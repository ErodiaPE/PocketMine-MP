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

use pocketmine\nbt\tag\CompoundTag;

class Occupant
{
	private int $ticksLeftToStay;
	private string $actorIdentifier;
	private CompoundTag $saveData;
	//private Sound $workSound = Sound::BLOCK_BEEHIVE_WORK;
	//private float $workSoundPitch = 1.0;
	private bool $hasNectar;
	private bool $muted = false;

	public function __construct(
		int $ticksLeftToStay,
		string $actorIdentifier,
		bool $hasNectar,
		CompoundTag $saveData
	) {
		$this->ticksLeftToStay = $ticksLeftToStay;
		$this->actorIdentifier = $actorIdentifier;
		$this->hasNectar = $hasNectar;
		$this->saveData = clone $saveData;
	}

	public static function fromNBT(CompoundTag $saved) : self
	{
		$self = new self(
			$saved->getInt("TicksLeftToStay"),
			$saved->getString("ActorIdentifier"),
			$saved->getByte("HasNectar"),
			$saved->getCompoundTag("SaveData")
		);

		/*if ($saved->contains("WorkSound")) {
			try {
				$self->workSound = Sound::from($saved->getString("WorkSound"));
			} catch (\Throwable) {
				// ignore invalid sound
			}
		}*/

		//if ($saved->contains("WorkSoundPitch")) {
		//	$self->workSoundPitch = $saved->getFloat("WorkSoundPitch");
		//}

		$self->muted = $saved->getByte("Muted");
		return $self;
	}

	public function saveNBT() : CompoundTag
	{
		return CompoundTag::create()
			->setString("ActorIdentifier", $this->actorIdentifier)
			->setInt("TicksLeftToStay", $this->ticksLeftToStay)
			->setTag("SaveData", clone $this->saveData)
			//->setString("WorkSound", $this->workSound->name)
			//->setFloat("WorkSoundPitch", $this->workSoundPitch)
			->setByte("HasNectar", $this->hasNectar)
			->setByte("Muted", $this->muted);
	}

	public function getTicksLeftToStay() : int { return $this->ticksLeftToStay; }
	public function setTicksLeftToStay(int $v) : void { $this->ticksLeftToStay = $v; }

	public function getActorIdentifier() : string { return $this->actorIdentifier; }
	public function setActorIdentifier(string $v) : void { $this->actorIdentifier = $v; }

	public function getSaveData() : CompoundTag { return clone $this->saveData; }
	public function setSaveData(CompoundTag $v) : void { $this->saveData = clone $v; }

	//public function getWorkSound(): Sound { return $this->workSound; }
	//public function setWorkSound(Sound $v): void { $this->workSound = $v; }
	//public function getWorkSoundPitch(): float { return $this->workSoundPitch; }
	//public function setWorkSoundPitch(float $v): void { $this->workSoundPitch = $v; }

	public function getHasNectar() : bool { return $this->hasNectar; }
	public function setHasNectar(bool $v) : void { $this->hasNectar = $v; }

	public function isMuted() : bool { return $this->muted; }
	public function setMuted(bool $v) : void { $this->muted = $v; }
}
