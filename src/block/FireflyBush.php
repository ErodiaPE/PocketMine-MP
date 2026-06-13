<?php

declare(strict_types=1);

namespace pocketmine\block;

final class FireflyBush extends Flowable{

	public function canBeReplaced() : bool{
		return true;
	}

	public function getLightLevel() : int{
		return 2;
	}
}