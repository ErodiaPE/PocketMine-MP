<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\tile\CommandBlock as CommandBlockTile;
use pocketmine\block\utils\AnyFacingTrait;
use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class CommandBlock extends Opaque
{
	use AnyFacingTrait {
		describeBlockOnlyState as describeAnyFacingBlockOnlyState;
	}

	protected bool $conditional = false;

	public function isConditional(): bool
	{
		return $this->conditional;
	}

	public function setConditional(bool $conditional): self
	{
		$this->conditional = $conditional;
		return $this;
	}

	protected function describeBlockOnlyState(RuntimeDataDescriber $w): void
	{
		$this->describeAnyFacingBlockOnlyState($w);
		$w->bool($this->conditional);
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null): bool
	{
		$this->setFacing(Facing::opposite($face));
		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		if($player instanceof Player){

			$tile = $this->position->getWorld()->getTile($this->position);
			if($tile instanceof CommandBlockTile){
				$player->setCurrentWindow($tile->getInventory());
				return true;
			}
		}
		return false;
	}
}