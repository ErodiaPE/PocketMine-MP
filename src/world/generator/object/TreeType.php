<?php

declare(strict_types=1);

namespace pocketmine\world\generator\object;

use pocketmine\utils\LegacyEnumShimTrait;

enum TreeType{
	use LegacyEnumShimTrait;

	case OAK;
	case SPRUCE;
	case BIRCH;
	case JUNGLE;
	case ACACIA;
	case DARK_OAK;

	case CRIMSON;
	case WARPED;
	case AZALEA;

	case CHERRY;
	case MANGROVE;
	case BAMBOO;
	case PALE_OAK;

	public function getDisplayName() : string{
		return match($this){
			self::OAK => "Oak",
			self::SPRUCE => "Spruce",
			self::BIRCH => "Birch",
			self::JUNGLE => "Jungle",
			self::ACACIA => "Acacia",
			self::DARK_OAK => "Dark Oak",

			self::CRIMSON => "Crimson",
			self::WARPED => "Warped",
			self::AZALEA => "Azalea",

			self::CHERRY => "Cherry",
			self::MANGROVE => "Mangrove",
			self::BAMBOO => "Bamboo",
			self::PALE_OAK => "Pale Oak",
		};
	}
}