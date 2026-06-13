<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\math\Facing;

enum Orientation{
	case DOWN_EAST;
	case DOWN_NORTH;
	case DOWN_SOUTH;
	case DOWN_WEST;
	case EAST_UP;
	case NORTH_UP;
	case SOUTH_UP;
	case UP_EAST;
	case UP_NORTH;
	case UP_SOUTH;
	case UP_WEST;
	case WEST_UP;

	/**
	 * @return int
	 */
	public function getFirst() : int{
		return match ($this) {
			self::DOWN_EAST,
			self::DOWN_NORTH,
			self::DOWN_SOUTH,
			self::DOWN_WEST => Facing::DOWN,

			self::EAST_UP => Facing::EAST,

			self::NORTH_UP => Facing::NORTH,

			self::SOUTH_UP => Facing::SOUTH,

			self::UP_EAST,
			self::UP_NORTH,
			self::UP_SOUTH,
			self::UP_WEST => Facing::UP,

			self::WEST_UP => Facing::WEST,
		};
	}

	/**
	 * @return int
	 */
	public function getSecond() : int{
		return match ($this) {
			self::DOWN_EAST,
			self::UP_EAST => Facing::EAST,

			self::DOWN_NORTH,
			self::UP_NORTH => Facing::NORTH,

			self::DOWN_SOUTH,
			self::UP_SOUTH => Facing::SOUTH,

			self::DOWN_WEST,
			self::UP_WEST => Facing::WEST,

			self::EAST_UP,
			self::NORTH_UP,
			self::SOUTH_UP,
			self::WEST_UP => Facing::UP,
		};
	}

	/**
	 * @param int $first
	 * @param int $second
	 *
	 * @return self|null
	 */
	public static function getByFaces(int $first, int $second) : ?self{
		foreach(self::cases() as $case){
			if($case->getFirst() === $first && $case->getSecond() === $second){
				return $case;
			}
		}

		return null;
	}
}