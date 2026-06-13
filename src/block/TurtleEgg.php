<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\BlockEventHelper;
use pocketmine\block\utils\CrackedState;
use pocketmine\block\utils\TurtleEggCount;
use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\world\particle\BoneMealParticle;
use pocketmine\world\sound\TurtleEggCrackSound;

class TurtleEgg extends Flowable{

	private TurtleEggCount $eggs = TurtleEggCount::ONE_EGG;
	private CrackedState $cracks = CrackedState::NO_CRACKS;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w): void
	{
		$w->enum($this->cracks);
		$w->enum($this->eggs);
	}

	/**
	 * @return TurtleEggCount
	 */
	public function getEggs() : TurtleEggCount{
		return $this->eggs;
	}

	/**
	 * @param TurtleEggCount $eggs
	 */
	public function setEggs(TurtleEggCount $eggs) : void{
		$this->eggs = $eggs;
	}

	/**
	 * @return CrackedState
	 */
	public function getCracks() : CrackedState{
		return $this->cracks;
	}

	/**
	 * @param CrackedState $cracks
	 */
	public function setCracks(CrackedState $cracks) : void{
		$this->cracks = $cracks;
	}

	public function onScheduledUpdate() : void{
		$world = $this->position->getWorld();
		$down = $world->getBlock($this->position->getSide(Facing::DOWN));

		if($down->getTypeId() !== BlockTypeIds::SAND){
			return;
		}

		$time = $world->getTimeOfDay();

		$chance = ($time > 13000 && $time < 23000) || mt_rand(0, 499) === 0;

		if(!$chance){
			return;
		}

		if($this->cracks != CrackedState::MAX_CRACKED){
			$new = clone $this;
			$new->cracks = $new->cracks->next();

			BlockEventHelper::grow($this, $new, null);
		}else{
			$this->hatch();
		}
	}

	private function hatch() : void{
		$world = $this->position->getWorld();
		$eggs = $this->eggs;

		$world->addSound($this->position, new TurtleEggCrackSound());

		$spawnCount = $eggs;

		for($i = 0; $i < $spawnCount; $i++){
			// TODO: Spawn turtle
			$pos = $this->position->add(
				0.3 + ($i * 0.2),
				0,
				0.3
			);
		}

		$world->setBlock($this->position, VanillaBlocks::AIR());
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		if((!$item->getBlock() instanceof self) || $player?->isSneaking()){
			return false;
		}

		if($this->eggs == TurtleEggCount::FOUR_EGG){
			return false;
		}

		$new = clone $this;
		$new->eggs = $new->eggs->next();

		if(!BlockEventHelper::grow($this, $new, $player)){
			return false;
		}

		$item->pop();

		$world = $this->position->getWorld();

		if($world->getBlock($this->position->getSide(Facing::DOWN))->getTypeId() === BlockTypeIds::SAND){
			$world->addParticle($this->position, new BoneMealParticle());
		}

		return true;
	}

	public function onBreak(Item $item, ?Player $player = null, array &$returnedItems = []) : bool{
		$world = $this->position->getWorld();

		if(!$item->hasEnchantment(VanillaEnchantments::SILK_TOUCH())){
			$world->addSound($this->position, new TurtleEggCrackSound());
		}

		if($this->eggs != TurtleEggCount::ONE_EGG){
			$new = clone $this;
			$new->eggs = $new->eggs->before();
			$world->setBlock($this->position, $new);
			return true;
		}

		return parent::onBreak($item, $player, $returnedItems);
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$down = $this->position->getWorld()->getBlock($this->position->getSide(Facing::DOWN));

		if(!$down->isSolid()){
			return false;
		}

		$tx->addBlock($this->position, $this);
		if($down->getTypeId() === BlockTypeIds::SAND){
			$this->position->getWorld()->addParticle($this->position, new BoneMealParticle());
		}

		return true;
	}

	protected function recalculateCollisionBoxes() : array{
		return [
			new AxisAlignedBB(
				$this->position->x + 3/16,
				$this->position->y,
				$this->position->z + 3/16,
				$this->position->x + 13/16,
				$this->position->y + 7/16,
				$this->position->z + 13/16
			),
			new AxisAlignedBB(
				$this->position->x,
				$this->position->y,
				$this->position->z,
				$this->position->x + 1,
				$this->position->y + 8/16,
				$this->position->z + 1
			)
		];
	}

	public function getDrops(Item $item) : array{
		return [];
	}

	public function canBeReplaced() : bool{
		return true;
	}

	public function hasEntityCollision() : bool{
		return true;
	}
}