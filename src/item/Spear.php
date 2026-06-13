<?php

namespace pocketmine\item;

use pocketmine\event\player\PlayerSpearStabEvent;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\sound\SpearLungeSound;
use pocketmine\world\sound\SpearUseSound;

class Spear extends TieredTool {
	/**
	 * @return int
	 */
	public function getAttackPoints() : int{
		return $this->tier->getBaseAttackPoints() - 3;
	}

	/**
	 * @return int
	 */
	public function getCooldownTicks() : int{
		return 20;
	}

	/**
	 * @param Player  $player
	 * @param Vector3 $directionVector
	 * @param array   $returnedItems
	 *
	 * @return ItemUseResult
	 */
	public function onClickAir(Player $player, Vector3 $directionVector, array &$returnedItems) : ItemUseResult{
		$player->broadcastSound(new SpearUseSound($this));
		return ItemUseResult::SUCCESS();
	}

	/**
	 * @param Player $player
	 *
	 * @return void
	 */
	public function onStab(Player $player) : void{
		$ev = new PlayerSpearStabEvent($player, $this);
		$ev->call();

		if ($ev->isCancelled()) {
			return;
		}

		if ($player->getHungerManager()->getFood() > 6 && !$player->isGliding() && !$player->isSwimming() && !$player->isUnderwater()) {
			$level = $this->getEnchantmentLevel(VanillaEnchantments::LUNGE());
			$dir = $player->getDirectionVector();
			$dir->y = 0;

			if ($level > 0 && $dir->lengthSquared() != 0) {
				$dir = $dir->normalize()->multiply(0.5 + ($level * 0.4));

				$player->broadcastSound(new SpearLungeSound($level));
				$player->setMotion($player->getMotion()->add($dir->x, $dir->y, $dir->z));
				$player->getHungerManager()->exhaust(4 * $level);
			}
		}

		/*$movementSpeed = $player->getMovementSpeed();
		if ($movementSpeed < 0.13) {
			$player->broadcastSound(new SpearAttackMissSound($this));
			return;
		}

		$world = $player->getWorld();

		$eyePos = $player->getEyePos();
		$dir = $player->getDirectionVector()->normalize();

		$maxDistance = 1.0;
		$minDot = 0.866;
		$bestScore = -1;

		$target = null;

		$box = $player->getBoundingBox()->expand($maxDistance, $maxDistance, $maxDistance);
		foreach($world->getNearbyEntities($box, $player) as $entity){
			if (!$entity instanceof Living || !$entity->isAlive()) {
				continue;
			}

			$targetPos = $entity->getPosition()->add(0, $entity->getEyeHeight() * 0.5, 0);

			$dist = $eyePos->distance($targetPos);
			if ($dist > $maxDistance) {
				continue;
			}

			$toEntity = $targetPos->subtractVector($eyePos)->normalize();
			$dot = $dir->dot($toEntity);

			if ($dot < $minDot) {
				continue;
			}

			$score = $dot - ($dist / $maxDistance) * 0.1;
			if ($score <= $bestScore) {
				continue;
			}

			$bestScore = $score;
			$target = $entity;
		}

		if ($target == null) {
			$player->broadcastSound(new SpearAttackMissSound($this));
			return;
		}

		$damage = $this->getAttackPoints() + ($this->getEnchantmentLevel(VanillaEnchantments::LUNGE()) * 1.5);
		$event = new EntityDamageByEntityEvent($player, $target, EntityDamageEvent::CAUSE_ENTITY_ATTACK, $damage);
		$target->attack($event);

		if ($event->isCancelled()) {
			return;
		}

		$player->broadcastSound(new SpearAttackHitSound($this));*/
	}

	/**
	 * @param Player $player
	 *
	 * @return void
	 */
	public function whileUsing(Player $player) : void{
		/*$player->resetItemCooldown($this, 5);

		$movementSpeed = $player->getMovementSpeed();
		if ($movementSpeed < 0.13) {
			return;
		}

		$world = $player->getWorld();
		$dir = $player->getDirectionVector()->normalize()->multiply(1.5);

		$box = $player->getBoundingBox()->expand(1.5, 1.0, 1.5)->offset($dir->x, $dir->y, $dir->z);
		$damage = $this->getAttackPoints() * 1.5;

		$closest = null;
		$closestDistance = PHP_INT_MAX;

		foreach($world->getNearbyEntities($box, $player) as $entity){
			if (!$entity instanceof Living || !$entity->isAlive()) {
				continue;
			}

			$dist = $entity->getPosition()->distanceSquared($player->getPosition());
			if ($dist < $closestDistance) {
				$closestDistance = $dist;
				$closest = $entity;
			}
		}

		if ($closest == null) {
			return;
		}

		$finalDamage = $damage + ($movementSpeed * 3.0);
		$event = new EntityDamageByEntityEvent($player, $closest, EntityDamageEvent::CAUSE_ENTITY_ATTACK, $finalDamage);
		$closest->attack($event);

		if ($event->isCancelled()) {
			return;
		}

		$player->broadcastSound(new SpearAttackHitSound($this));*/
	}
}