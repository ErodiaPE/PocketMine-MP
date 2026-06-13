<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\entity\Location;
use pocketmine\entity\projectile\Arrow as ArrowEntity;
use pocketmine\event\entity\EntityShootCrossBowEvent;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\sound\CrossbowLoadingEndSound;
use pocketmine\world\sound\CrossbowLoadingMiddleSound;
use pocketmine\world\sound\CrossbowLoadingStartSound;
use pocketmine\world\sound\CrossbowQuickChargeEndSound;
use pocketmine\world\sound\CrossbowQuickChargeMiddleSound;
use pocketmine\world\sound\CrossbowQuickChargeStartSound;
use pocketmine\world\sound\CrossbowShootSound;

class CrossBow extends Tool implements Releasable{

	public function getFuelTime() : int{
		return 200;
	}

	public function getMaxDurability() : int{
		return 464;
	}

	public function whileUsing(Player $player) : void{
		if($this->getLoadTick() === null){
			return;
		}

		if($this->isCharged()){
			return;
		}

		$needTickUsed = 25;
		$level = $this->getEnchantmentLevel(VanillaEnchantments::QUICK_CHARGE());

		if($level > 0){
			$needTickUsed -= $level * 5;
		}

		$tickUsed = $player->getServer()->getTick() - $this->getLoadTick();
		if($tickUsed != $needTickUsed / 2){
			return;
		}

		$player->broadcastSound($level > 0 ? new CrossbowQuickChargeMiddleSound() : new CrossbowLoadingMiddleSound());
	}

	public function onClickAir(Player $player, Vector3 $directionVector, array &$returnedItems) : ItemUseResult{
		if(!$this->isCharged()){
			if($this->getLoadTick() === null){
				$this->setLoadTick($player->getServer()->getTick());
			}

			return ItemUseResult::SUCCESS;
		}

		if(!$this->isCharged()){
			$arrow = VanillaItems::ARROW();

			$inventory = match (true) {
				$player->getOffHandInventory()->contains($arrow) => $player->getOffHandInventory(),
				$player->getInventory()->contains($arrow) => $player->getInventory(),
				default => null
			};

			if($player->hasFiniteResources() && $inventory === null){
				return ItemUseResult::FAIL;
			}

			$this->setLoadTick($player->getServer()->getTick());
			$player->broadcastSound($this->getEnchantmentLevel(VanillaEnchantments::QUICK_CHARGE()) > 0 ?
				new CrossbowQuickChargeStartSound() :
				new CrossbowLoadingStartSound()
			);
			return ItemUseResult::SUCCESS;
		}

		$location = $player->getLocation();
		$dir = $player->getDirectionVector();

		$ev = new EntityShootCrossBowEvent($player, $this, []);

		$level = $this->getEnchantmentLevel(VanillaEnchantments::MULTISHOT());

		if($level > 0){
			$projectiles = [];

			$location = Location::fromObject(
				$dir->multiply(1.3)->addVector($player->getEyePos()),
				$player->getWorld(),
				$location->getYaw(),
				$location->getPitch()
			);

			$location->yaw -= 10;

			for($i = 0; $i < 3; $i++){
				$arrow = new ArrowEntity($location, $player, false);
				$arrow->setOwningEntity($player);

				$projectiles[] = $arrow;

				$location->yaw += 10;
			}

			$ev->setProjectiles($projectiles);
		}else{
			$entity = new ArrowEntity(
				Location::fromObject(
					$player->getEyePos(),
					$player->getWorld(),
					($location->yaw > 180 ? 360 : 0) - $location->yaw,
					-$location->pitch
				),
				$player,
				false
			);

			$entity->setMotion($player->getDirectionVector());
			$ev->setProjectiles([$entity]);
		}

		$ev->call();
		if($ev->isCancelled()){
			foreach($ev->getProjectiles() as $projectile){
				$projectile->flagForDespawn();
			}

			return ItemUseResult::FAIL;
		}

		$accepted = false;
		foreach($ev->getProjectiles() as $projectile){
			$projectile->spawnToAll();
			$accepted = true;
		}

		if(!$accepted){
			return ItemUseResult::FAIL;
		}

		$this->setLoadTick(null);
		$this->setCharged();
		$player->setUsingItem(false);

		$player->broadcastSound(new CrossbowShootSound());

		if ($player->isSurvival()) {
			$this->applyDamage($level > 0 ? 3 : 0);
		}
		return ItemUseResult::SUCCESS;
	}

	public function onReleaseUsing(Player $player, array &$returnedItems) : ItemUseResult{

		if($this->getLoadTick() === null){
			return ItemUseResult::FAIL;
		}

		if($this->isCharged()){
			return ItemUseResult::FAIL;
		}

		$needTickUsed = 25;
		$level = $this->getEnchantmentLevel(VanillaEnchantments::QUICK_CHARGE());

		if($level > 0){
			$needTickUsed -= $level * 5;
		}

		$tickUsed = $player->getServer()->getTick() - $this->getLoadTick();
		if($tickUsed < $needTickUsed){
			return ItemUseResult::FAIL;
		}

		$arrow = VanillaItems::ARROW();

		$inventory = match (true) {
			$player->getOffHandInventory()->contains($arrow) => $player->getOffHandInventory(),
			$player->getInventory()->contains($arrow) => $player->getInventory(),
			default => null
		};

		if($player->hasFiniteResources() && $inventory === null){
			return ItemUseResult::FAIL;
		}

		$this->setCharged($arrow);
		$player->broadcastSound($level > 0 ? new CrossbowQuickChargeEndSound() : new CrossbowLoadingEndSound());

		if($player->hasFiniteResources()){
			$inventory?->removeItem($arrow);
		}

		$this->setLoadTick(null);
		return ItemUseResult::SUCCESS;
	}

	public function canStartUsingItem(Player $player) : bool{
		$arrow = VanillaItems::ARROW();

		return $this->isCharged()
			|| (!$player->hasFiniteResources()
				|| $player->getOffHandInventory()->contains($arrow)
				|| $player->getInventory()->contains($arrow));
	}

	public function isCharged() : bool{
		return $this->getNamedTag()->getTag("chargedItem") !== null;
	}

	public function setCharged(?Item $item = null) : void{
		if($item !== null){
			$this->getNamedTag()->setTag("chargedItem", $item->nbtSerialize());
			return;
		}

		$this->getNamedTag()->removeTag("chargedItem");
	}

	public function getLoadTick() : ?int{
		return $this->getNamedTag()->getTag("loadTick") !== null
			? $this->getNamedTag()->getInt("loadTick")
			: null;
	}

	public function setLoadTick(?int $tick) : void{
		if($tick === null){
			$this->getNamedTag()->removeTag("loadTick");
			return;
		}

		$this->getNamedTag()->setInt("loadTick", $tick);
	}
}