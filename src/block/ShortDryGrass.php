<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Fertilizer;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\particle\BoneMealParticle;

class ShortDryGrass extends Flowable{

	public function canBeReplaced() : bool{
		return true;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
		if($item instanceof Fertilizer){
			if($player !== null && !$player->isCreative()){
				$item->pop();
			}

			$world = $this->position->getWorld();

			$world->addParticle($this->position, new BoneMealParticle());
			$world->setBlock($this->position, VanillaBlocks::TALL_DRY_GRASS());
			return true;
		}

		return false;
	}
}