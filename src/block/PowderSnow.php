<?php

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