<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\item\Shears;

class Bush extends Flowable{

	public function canBeReplaced() : bool{
		return true;
	}

	/**
	 * @return Item[]
	 */
	public function getDrops(Item $item) : array{
		$hasSilkTouch = $item->hasEnchantment(VanillaEnchantments::SILK_TOUCH());

		if($item instanceof Shears || $hasSilkTouch){
			return [$this->asItem()];
		}

		return [];
	}
}