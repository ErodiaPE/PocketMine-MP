<?php

declare(strict_types=1);

namespace pocketmine\block;

class TallDryGrass extends Flowable{

	public function canBeReplaced() : bool{
		return true;
	}
}