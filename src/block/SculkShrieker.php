<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class SculkShrieker extends Transparent{
	protected bool $active = false;
	protected bool $canSummon = false;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w): void
	{
		$w->bool($this->active);
		$w->bool($this->canSummon);
	}

	public function isActive(): bool
	{
		return $this->active;
	}

	public function setActive(bool $active): self
	{
		$this->active = $active;
		return $this;
	}

	public function canSummon(): bool
	{
		return $this->canSummon;
	}

	public function setCanSummon(bool $canSummon): self
	{
		$this->canSummon = $canSummon;
		return $this;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		$this->position->getWorld()->setBlock($this->position, $this->setCanSummon(!$this->canSummon));
		return true;
	}
}