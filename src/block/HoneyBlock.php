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

use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\math\AxisAlignedBB;
use function floor;

class HoneyBlock extends Opaque{

	public function getFrictionFactor() : float{
		return 0.4;
	}

	public function onEntityLand(Entity $entity) : ?float{
		$fallDistance = $entity->getFallDistance();

		$jumpBoost = 0;
		if($entity instanceof Living){
			$effect = $entity->getEffects()->get(VanillaEffects::JUMP_BOOST());
			if($effect !== null){
				$jumpBoost = $effect->getEffectLevel();
			}
		}

		$damage = (int) floor($fallDistance - 3 - $jumpBoost);
		$damage *= 0.2;

		if($damage > 0){
			$entity->attack(new EntityDamageEvent(
				$entity,
				EntityDamageEvent::CAUSE_FALL,
				$damage
			));
		}

		$entity->resetFallDistance();
		return null;
	}

	protected function recalculateCollisionBoxes() : array{
		return [AxisAlignedBB::one()->addCoord(1, 1, 1)];
	}

	public function getLightFilter() : int{
		return 1;
	}
}
