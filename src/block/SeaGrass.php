<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\SeaGrassType;
use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Fertilizer;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\world\particle\BoneMealParticle;

class SeaGrass extends Flowable{

	protected SeaGrassType $type = SeaGrassType::DEFAULT;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w) : void{
		$w->enum($this->type);
	}

	public function getType() : SeaGrassType{
		return $this->type;
	}

	public function setType(SeaGrassType $type) : self{
		$this->type = $type;
		return $this;
	}

	public function ticksRandomly() : bool{
		return true;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if ($player !== null) {
			$world = $this->position->getWorld();

			$down = $world->getBlock($this->position->getSide(Facing::DOWN));
			$up = $world->getBlock($this->position->getSide(Facing::UP));

			if(
				$down->isSolid() &&
				!$down instanceof Magma &&
				!$down instanceof SoulSand &&
				$up instanceof Water
			){
				$tx->addBlock($this->position, $this);
				return true;
			}

			return false;
		}

		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	public function onScheduledUpdate() : void{
		$world = $this->position->getWorld();

		$up = $world->getBlock($this->position->getSide(Facing::UP));
		$down = $world->getBlock($this->position->getSide(Facing::DOWN));

		if(!$up instanceof Water && !$up instanceof self){
			$world->useBreakOn($this->position);
			return;
		}

		if(
			!$down->isSolid() ||
			$down instanceof Magma ||
			$down instanceof SoulSand
		){
			$world->useBreakOn($this->position);
		}
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{

		if(!$item instanceof Fertilizer || $this->getType() !== SeaGrassType::DEFAULT){
			return false;
		}

		$world = $this->position->getWorld();

		$up = $world->getBlock($this->position->getSide(Facing::UP));

		if(!$up instanceof Water){
			return false;
		}

		if($player !== null && !$player->isCreative()){
			$item->pop();
		}

		$world->addParticle($this->position, new BoneMealParticle());

		$oldDouble = $this->position->getWorld()->getBlock($this->position->getSide(Facing::UP));

		$this->position->getWorld()->setBlock($this->position, VanillaBlocks::SEAGRASS()->setType(SeaGrassType::DOUBLE_BOT));
		$this->position->getWorld()->setBlock($this->position, VanillaBlocks::SEAGRASS()->setType(SeaGrassType::DOUBLE_TOP));
		return true;
	}

	public function getDrops(Item $item) : array{
		if($item->getBlockToolType() === BlockToolType::SHEARS){
			return [$this->asItem()];
		}

		return [];
	}

	public function canBeReplaced() : bool{
		return true;
	}
}