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

namespace pocketmine\item;

use pocketmine\entity\Entity;
use pocketmine\player\Player;
use pocketmine\world\particle\SmashAttackGroundDustParticle;
use pocketmine\world\sound\MaceHeavySmashGroundSound;
use pocketmine\world\sound\MaceSmashGroundSound;
use function abs;
use function min;

class Mace extends Tool{

	public function getMaxDurability() : int{
		return 501;
	}

	public function getAttackPoints() : int{
		return 5;
	}

	public function onAttackEntity(Entity $victim, array &$returnedItems) : bool{
		return true;
	}

	/**
	 * @param Player $entity
	 */
	public function getAttackDamage(Entity $entity) : float{

		$fallDistance = $entity->getFallDistance();

		$base = 5;
		$bonus = 0;
		if($fallDistance > 1){
			$bonus = min(($fallDistance - 1) * 2.5, 40);
		}

		$motionY = $entity->getMotion()->y;
		if($motionY < 0){
			$bonus += abs($motionY) * 10;
		}

		$entity->resetFallDistance();
		return $base + $bonus;
	}

	public function onPostAttack(Entity $entity, float $damage) : void{
		if ($damage >= 7) {
			$entity->getWorld()->addParticle($entity->getPosition(), new SmashAttackGroundDustParticle());
			if ($damage >= 16) {
				$entity->broadcastSound(new MaceHeavySmashGroundSound());
			} else {
				$entity->broadcastSound(new MaceSmashGroundSound());
			}
		}
	}
}
