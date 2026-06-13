<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\DripstoneThickness;
use pocketmine\block\utils\Fallable;
use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\entity\Entity;
use pocketmine\entity\Location;
use pocketmine\entity\object\FallingBlock;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\world\sound\BlockBreakSound;
use pocketmine\world\sound\CauldronDripLavaSound;
use pocketmine\world\sound\CauldronDripWaterSound;
use pocketmine\world\sound\Sound;

class PointedDripstone extends Transparent implements Fallable{
	private DripstoneThickness $thickness = DripstoneThickness::TIP;
	private bool $hanging = false;

	protected function describeBlockOnlyState(RuntimeDataDescriber $w) : void{
		$w->enum($this->thickness);
		$w->bool($this->hanging);
	}

	public function getThickness() : DripstoneThickness{
		return $this->thickness;
	}

	public function setThickness(DripstoneThickness $thickness) : self{
		$this->thickness = $thickness;
		return $this;
	}

	public function isHanging() : bool{
		return $this->hanging;
	}

	public function setHanging(bool $hanging) : self{
		$this->hanging = $hanging;
		return $this;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$world = $this->position->getWorld();
		$up = $world->getBlock($this->position->getSide(Facing::UP));
		$down = $world->getBlock($this->position->getSide(Facing::DOWN));

		if($up instanceof Air && $down instanceof Air){
			return false;
		}

		if($up instanceof PointedDripstone){
			$this->hanging = true;
		} elseif($down instanceof PointedDripstone){
			$this->hanging = false;
		} else {
			$this->hanging = ($face !== Facing::UP);
		}

		$this->thickness = DripstoneThickness::TIP;
		$tx->addBlock($this->position, $this);

		$this->updateStructure($tx);

		return true;
	}

	public function onBreak(Item $item, ?Player $player = null, array &$returnedItems = []) : bool{
		$world = $this->position->getWorld();
		$result = parent::onBreak($item, $player, $returnedItems);


		$directionToRemaining = $this->hanging ? Facing::UP : Facing::DOWN;
		$neighborPos = $this->position->getSide($directionToRemaining);
		$neighbor = $world->getBlock($neighborPos);

		if($neighbor instanceof PointedDripstone && $neighbor->isHanging() === $this->hanging){
			$tx = new BlockTransaction($world);
			$neighbor->updateStructure($tx);
			$tx->apply();
		}

		$oppositeDirection = $this->hanging ? Facing::DOWN : Facing::UP;
		$oppositeNeighbor = $world->getBlock($this->position->getSide($oppositeDirection));
		if($oppositeNeighbor instanceof PointedDripstone && $oppositeNeighbor->getThickness() === DripstoneThickness::MERGE){
			$tx = new BlockTransaction($world);
			$oppositeNeighbor->updateStructure($tx);
			$tx->apply();
		}

		return $result;
	}

	private function updateStructure(BlockTransaction $tx) : void{
		$world = $this->position->getWorld();

		$sourceDirection = $this->hanging ? Facing::UP : Facing::DOWN;
		$tipDirection = Facing::opposite($sourceDirection);

		$basePos = $this->position;
		while(($prev = $tx->fetchBlock($basePos->getSide($sourceDirection)) ?? $world->getBlock($basePos->getSide($sourceDirection))) instanceof PointedDripstone){
			$basePos = $basePos->getSide($sourceDirection);
		}

		$currentPos = $basePos;
		$columnBlocks = [];

		while(($block = $tx->fetchBlock($currentPos) ?? $world->getBlock($currentPos)) instanceof PointedDripstone){
			if($block->isHanging() === $this->hanging){
				$columnBlocks[] = $block;
			} else {
				break;
			}
			$currentPos = $currentPos->getSide($tipDirection);
		}

		$totalLength = count($columnBlocks);

		foreach($columnBlocks as $index => $b){
			$updatedBlock = clone $b;

			if($totalLength === 1){
				$updatedBlock->setThickness(DripstoneThickness::TIP);
			} else {
				if($index === 0){
					$updatedBlock->setThickness(DripstoneThickness::BASE);
				} elseif($index === $totalLength - 1){
					$updatedBlock->setThickness(DripstoneThickness::TIP);
				} elseif($index === $totalLength - 2){
					$updatedBlock->setThickness(DripstoneThickness::FRUSTUM);
				} else {
					$updatedBlock->setThickness(DripstoneThickness::MIDDLE);
				}
			}
			$tx->addBlock($updatedBlock->position, $updatedBlock);
		}

		$tipBlock = $columnBlocks[$totalLength - 1] ?? $this;
		$oppositeBlock = $world->getBlock($tipBlock->position->getSide($tipDirection));

		if($oppositeBlock instanceof PointedDripstone && $oppositeBlock->isHanging() !== $this->hanging){
			$updatedTip = clone $tipBlock;
			$updatedTip->setThickness(DripstoneThickness::MERGE);
			$tx->addBlock($updatedTip->position, $updatedTip);

			$updatedOpposite = clone $oppositeBlock;
			$updatedOpposite->setThickness(DripstoneThickness::MERGE);
			$tx->addBlock($updatedOpposite->position, $updatedOpposite);
		}
	}

	public function ticksRandomly() : bool{
		return true;
	}

	public function onRandomTick() : void{
		if($this->thickness === DripstoneThickness::TIP){
			if(mt_rand(1, 100000) <= 1137){
				$this->grow();
			}

			if($this->hanging){
				$this->drippingLiquid();
			}
		}
	}

	public function onNearbyBlockChange() : void{
		$world = $this->position->getWorld();

		if(!$this->hanging){
			$down = $world->getBlock($this->position->getSide(Facing::DOWN));
			if(!$down->isSolid() && !$down instanceof PointedDripstone){
				$world->useBreakOn($this->position);
				return;
			}
		} else {
			$up = $world->getBlock($this->position->getSide(Facing::UP));
			if(!$up->isSolid() && !$up instanceof PointedDripstone){
				$this->fall();
				return;
			}
		}
	}

	private function fall() : void{
		$world = $this->position->getWorld();
		$currentPos = $this->position;

		$blocksToFall = [];
		while(($block = $world->getBlock($currentPos)) instanceof PointedDripstone){
			$blocksToFall[] = [
				"pos" => $currentPos,
				"block" => $block
			];
			$currentPos = $currentPos->getSide(Facing::DOWN);
		}

		foreach($blocksToFall as $data){
			$pos = $data["pos"];
			/** @var PointedDripstone $block */
			$block = $data["block"];

			$world->setBlock($pos, VanillaBlocks::AIR(), false);

			$fall = new FallingBlock(Location::fromObject($pos->add(0.5, 0, 0.5), $world), $block);
			$fall->spawnToAll();
		}
	}

	public function onEntityLand(Entity $entity) : ?float{
		if(!$this->hanging && $this->thickness === DripstoneThickness::TIP && $entity->getFallDistance() > 0){
			$damage = ($entity->getFallDistance() * 2) - 2;
			if($damage > 0){
				$entity->attack(new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_FALL, $damage));
			}
		}
		return null;
	}

	public function grow() : void{
		$world = $this->position->getWorld();
		$face = $this->hanging ? Facing::DOWN : Facing::UP;
		$targetPos = $this->position->getSide($face);
		$target = $world->getBlock($targetPos);

		if($target instanceof Air){
			$tx = new BlockTransaction($world);

			$newDripstone = VanillaBlocks::POINTED_DRIPSTONE()
				->setHanging($this->hanging)
				->setThickness(DripstoneThickness::TIP);

			$tx->addBlock($targetPos, $newDripstone);

			$this->updateStructure($tx);

			$tx->addBlock($this->position, $this);
			$tx->apply();
		}
	}

	private function drippingLiquid() : void{
		$world = $this->position->getWorld();

		$highestPDS = $this;
		while(($up = $world->getBlock($highestPDS->position->getSide(Facing::UP))) instanceof PointedDripstone){
			$highestPDS = $up;
		}

		$sourcePos = $highestPDS->position->getSide(Facing::UP, 2);
		$sourceBlock = $world->getBlock($sourcePos);

		if(!$sourceBlock instanceof Water && !$sourceBlock instanceof Lava){
			return;
		}

		$currentPos = $this->position->getSide(Facing::DOWN);
		while($world->getBlock($currentPos) instanceof Air){
			$currentPos = $currentPos->getSide(Facing::DOWN);
			if($currentPos->y < $world->getMinY()) return;
		}

		$cauldron = $world->getBlock($currentPos);
		if($cauldron instanceof Cauldron){
			$rand = mt_rand(1, 256);

			if($sourceBlock instanceof Lava && $rand <= 15){
				if($cauldron->getFluid()->isSame($cauldron->getEmptyFluid()) || $cauldron->getFluid() instanceof Lava){
					$cauldron->fillWithLava();
					$world->addSound($this->position, new CauldronDripLavaSound());
				}
			} elseif($sourceBlock instanceof Water && $rand <= 45){
				if($cauldron->getFluid()->isSame($cauldron->getEmptyFluid()) || $cauldron->getFluid() instanceof Water){
					$cauldron->fillWithWater();
					$world->addSound($this->position, new CauldronDripWaterSound());
				}
			}
		}
	}

	public function tickFalling() : ?Block{
		return null;
	}

	public function getFallDamagePerBlock() : float{ return 2.0; }
	public function getMaxFallDamage() : float{ return 40.0; }
	public function getLandSound() : ?Sound{ return null; }

	public function onHitGround(FallingBlock $blockEntity) : bool{
		$world = $blockEntity->getWorld();
		$pos = $blockEntity->getPosition();

		$world->dropItem($pos, $this->asItem());
		$world->addSound($pos, new BlockBreakSound($this));
		return false;
	}
}