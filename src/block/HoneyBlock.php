<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\math\AxisAlignedBB;

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