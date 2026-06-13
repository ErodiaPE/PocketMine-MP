<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class SculkCatalyst extends Transparent{
	protected bool $bloom = false;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w): void
	{
		$w->bool($this->bloom);
	}

	public function isBloom(): bool
	{
		return $this->bloom;
	}

	public function setBloom(bool $bloom): self
	{
		$this->bloom = $bloom;
		return $this;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		$this->position->getWorld()->setBlock($this->position, $this->setBloom(!$this->isBloom()));
		return true;
	}

	public function getLightLevel() : int{
		return 6;
	}
}