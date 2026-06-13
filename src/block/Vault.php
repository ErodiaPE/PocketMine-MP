<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\tile\Vault as TileVault;
use pocketmine\block\utils\HorizontalFacing;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\block\utils\VaultState;
use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class Vault extends Transparent implements HorizontalFacing{
	use HorizontalFacingTrait;

	private bool $ominous = false;
	private VaultState $state = VaultState::INACTIVE;

	/**
	 * @param RuntimeDataDescriber $w
	 *
	 * @return void
	 */
	protected function describeBlockOnlyState(RuntimeDataDescriber $w) : void{
		$w->horizontalFacing($this->facing);
		$w->enum($this->state);
		$w->bool($this->ominous);
	}

	/**
	 * @param Item        $item
	 * @param int         $face
	 * @param Vector3     $clickVector
	 * @param Player|null $player
	 * @param array       $returnedItems
	 *
	 * @return bool
	 */
	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		if($player === null) return false;

		$world = $this->position->getWorld();
		$tile = $world->getTile($this->position);

		if($tile instanceof TileVault){
			return $tile->tryOpen($player, $item);
		}

		return false;
	}

	/**
	 * @return VaultState
	 */
	public function getState() : VaultState{
		return $this->state;
	}

	/**
	 * @param VaultState $state
	 */
	public function setState(VaultState $state) : void{
		$this->state = $state;
	}

	/**
	 * @return bool
	 */
	public function isOminous() : bool{
		return $this->ominous;
	}

	/**
	 * @param bool $ominous
	 */
	public function setOminous(bool $ominous) : void{
		$this->ominous = $ominous;
	}

	public function onScheduledUpdate() : void{
		$tile = $this->position->getWorld()->getTile($this->position);
		if ($tile instanceof TileVault) {
			$tile->onUpdate();
		}
	}
}