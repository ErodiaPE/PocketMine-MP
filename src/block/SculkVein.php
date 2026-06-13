<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\MultiAnyFacing;
use pocketmine\block\utils\MultiAnySupportTrait;

class SculkVein extends Transparent implements MultiAnyFacing{
	use MultiAnySupportTrait;

	/**
	 * @return int[]
	 */
	protected function getInitialPlaceFaces(Block $blockReplace) : array{
		return $blockReplace instanceof SculkVein ? $blockReplace->faces : [];
	}
}