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

namespace pocketmine\entity\projectile;

use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Living;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\world\particle\WindExplosionParticle;
use pocketmine\world\sound\WindChargeBurstSound;

class WindCharge extends Throwable{
	public static function getNetworkTypeId() : string{ return EntityIds::WIND_CHARGE_PROJECTILE; }

	protected function getInitialSizeInfo() : EntitySizeInfo{ return new EntitySizeInfo(0.3125, 0.3125); }

	protected function getInitialDragMultiplier() : float{ return 0.01; }

	protected function getInitialGravity() : float{ return 0.00; }

	/**
	 * @return float
	 */
	public function getBurstRadius(): float{
		return 2;
	}

	/**
	 * @return float
	 */
	public function getKnockbackStrength() : float{
		return 0.2;
	}

	/**
	 * @param ProjectileHitEvent $event
	 *
	 * @return void
	 */
	protected function onHit(ProjectileHitEvent $event) : void{
		$world = $this->getWorld();
		$radius = $this->getBurstRadius();
		foreach($world->getNearbyEntities($this->getBoundingBox()->expand($radius, $radius, $radius), $this) as $entity) {
			if (!$entity instanceof Living) {
				continue;
			}

			$dist = $entity->getPosition()->distance($this->getPosition());
			if ($dist > $radius) {
				continue;
			}

			$this->knockback($entity);
		}

		$world->addSound($this->getPosition(), new WindChargeBurstSound());
		$world->addParticle($this->getPosition(), new WindExplosionParticle());

		$this->close();
	}

	/**
	 * @param Entity $entity
	 *
	 * @return void
	 */
	protected function knockBack(Entity $entity) : void{

		$from = $this->getLocation();
		$to = $entity->getLocation();

		$dx = $to->x - $from->x;
		$dz = $to->z - $from->z;

		$dist = max(0.001, sqrt($dx * $dx + $dz * $dz));

		$dx /= $dist;
		$dz /= $dist;

		$motion = $entity->getMotion();

		$motion->x *= 0.4;
		$motion->y *= 0.4;
		$motion->z *= 0.4;

		$strength = $this->getKnockbackStrength();

		$motion->x += $dx * $strength;
		$motion->z += $dz * $strength;

		$motion->y += 1.02;
		$motion->y = min($motion->y, 1.6);

		$entity->setMotion($motion);
	}
}