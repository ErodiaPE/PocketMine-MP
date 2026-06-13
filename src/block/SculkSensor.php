<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class SculkSensor extends Transparent{
	protected int $phase = 0;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w): void
	{
		$w->boundedIntAuto(0, 2, $this->phase);
	}

	public function getPhase(): int
	{
		return $this->phase;
	}

	public function setPhase(int $phase): static
	{
		$this->phase = $phase;
		return $this;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		$this->position->getWorld()->setBlock($this->position, $this->setPhase(($this->getPhase() + 1) % 3));
		return true;
	}

	public function getLightLevel(): int
	{
		return 1;
	}
}