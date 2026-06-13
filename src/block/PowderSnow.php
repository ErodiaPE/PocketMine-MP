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

use pocketmine\entity\projectile\Projectile;
use pocketmine\item\Item;
use pocketmine\math\RayTraceResult;
use pocketmine\world\sound\BucketFillPowderSnowSound;
use pocketmine\world\sound\CauldronEmptyPowderSnowSound;
use pocketmine\world\sound\Sound;

class PowderSnow extends Transparent{

	public function getDrops(Item $item) : array{
		return [];
	}

	public function onProjectileHit(Projectile $projectile, RayTraceResult $hitResult) : void{
		// TODO: If SmaillFireball hit break
	}

	public function getBucketFillSound() : Sound{
		return new BucketFillPowderSnowSound();
	}

	public function getBucketEmptySound() : Sound{
		return new CauldronEmptyPowderSnowSound();
	}
}
