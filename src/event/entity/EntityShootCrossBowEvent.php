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

namespace pocketmine\event\entity;

use pocketmine\entity\Living;
use pocketmine\entity\projectile\Projectile;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\item\Item;
use function count;
use function in_array;

/**
 * @phpstan-extends EntityEvent<Living>
 */
class EntityShootCrossBowEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	/** @var Projectile[] */
	private array $projectiles;
	private float $force = 1;

	public function __construct(
		Living $shooter,
		private Item $crossbow,
		array $projectiles,
	){
		$this->entity = $shooter;
		$this->projectiles = $projectiles;
	}

	/**
	 * @return Living
	 */
	public function getEntity(){
		return $this->entity;
	}

	public function getCrossbow() : Item{
		return $this->crossbow;
	}

	public function getProjectiles() : array{
		return $this->projectiles;
	}

	public function setProjectiles(array $projectiles) : void{
		foreach($this->projectiles as $oldProjectile){
			if(!in_array($oldProjectile, $projectiles, true) && count($oldProjectile->getViewers()) === 0){
				$oldProjectile->close();
			}
		}

		$this->projectiles = $projectiles;
	}

	public function getForce() : float{
		return $this->force;
	}

	public function setForce(float $force) : void{
		$this->force = $force;
	}
}
