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

namespace pocketmine\block\tile;

use pocketmine\block\inventory\CommandBlockInventory;
use pocketmine\inventory\Inventory;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\World;

class CommandBlock extends Spawnable implements Container {
	use ContainerTrait;

	protected CommandBlockInventory $inventory;
	public const TAG_CUSTOM_NAME = "CustomName";
	public const TAG_COMMAND = "Command";
	public const TAG_EXECUTE_ON_FIRST_TICK = "ExecuteOnFirstTick";
	public const TAG_LP_COMMAND_MODE = "LPCommandMode";
	public const TAG_LP_CONDITIONAL_MODE = "LPConditionalMode";
	public const TAG_LP_REDSTONE_MODE = "LPRedstoneMode";
	public const TAG_LAST_EXECUTION = "LastExecution";
	public const TAG_LAST_OUTPUT = "LastOutput";
	public const TAG_SUCCESS_COUNT = "SuccessCount";
	public const TAG_TICK_DELAY = "TickDelay";
	public const TAG_TRACK_OUTPUT = "TrackOutput";
	public const TAG_VERSION = "Version";
	public const TAG_AUTO = "auto";
	public const TAG_CONDITION_MET = "conditionMet";
	public const TAG_IS_MOVABLE = "isMovable";
	public const TAG_POWERED = "powered";

	private string $customName = "";
	private string $command = "";

	private bool $executeOnFirstTick = false;
	private int $lpCommandMode = 0;
	private bool $lpConditionalMode = false;
	private bool $lpRedstoneMode = false;

	private int $lastExecution = 0;
	private string $lastOutput = "";

	private int $successCount = 0;
	private int $tickDelay = 0;

	private bool $trackOutput = true;

	private int $version = 34;

	private bool $auto = false;
	private bool $conditionMet = false;
	private bool $isMovable = true;
	private bool $powered = false;

	public function __construct(World $world, Vector3 $pos){
		parent::__construct($world, $pos);
		$this->inventory = new CommandBlockInventory($this->position);
	}

	public function getCustomName() : string{
		return $this->customName;
	}

	public function setCustomName(string $customName) : void{
		$this->customName = $customName;
	}

	public function getCommand() : string{
		return $this->command;
	}

	public function setCommand(string $command) : void{
		$this->command = $command;
	}

	public function isExecuteOnFirstTick() : bool{
		return $this->executeOnFirstTick;
	}

	public function setExecuteOnFirstTick(bool $executeOnFirstTick) : void{
		$this->executeOnFirstTick = $executeOnFirstTick;
	}

	public function getLPCommandMode() : int{
		return $this->lpCommandMode;
	}

	public function setLPCommandMode(int $lpCommandMode) : void{
		$this->lpCommandMode = $lpCommandMode;
	}

	public function isLPConditionalMode() : bool{
		return $this->lpConditionalMode;
	}

	public function setLPConditionalMode(bool $lpConditionalMode) : void{
		$this->lpConditionalMode = $lpConditionalMode;
	}

	public function isLPRedstoneMode() : bool{
		return $this->lpRedstoneMode;
	}

	public function setLPRedstoneMode(bool $lpRedstoneMode) : void{
		$this->lpRedstoneMode = $lpRedstoneMode;
	}

	public function getLastExecution() : int{
		return $this->lastExecution;
	}

	public function setLastExecution(int $lastExecution) : void{
		$this->lastExecution = $lastExecution;
	}

	public function getLastOutput() : string{
		return $this->lastOutput;
	}

	public function setLastOutput(string $lastOutput) : void{
		$this->lastOutput = $lastOutput;
	}

	public function getSuccessCount() : int{
		return $this->successCount;
	}

	public function setSuccessCount(int $successCount) : void{
		$this->successCount = $successCount;
	}

	public function getTickDelay() : int{
		return $this->tickDelay;
	}

	public function setTickDelay(int $tickDelay) : void{
		$this->tickDelay = $tickDelay;
	}

	public function isTrackOutput() : bool{
		return $this->trackOutput;
	}

	public function setTrackOutput(bool $trackOutput) : void{
		$this->trackOutput = $trackOutput;
	}

	public function getVersion() : int{
		return $this->version;
	}

	public function setVersion(int $version) : void{
		$this->version = $version;
	}

	public function isAuto() : bool{
		return $this->auto;
	}

	public function setAuto(bool $auto) : void{
		$this->auto = $auto;
	}

	public function isConditionMet() : bool{
		return $this->conditionMet;
	}

	public function setConditionMet(bool $conditionMet) : void{
		$this->conditionMet = $conditionMet;
	}

	public function isMovable() : bool{
		return $this->isMovable;
	}

	public function setMovable(bool $isMovable) : void{
		$this->isMovable = $isMovable;
	}

	public function isPowered() : bool{
		return $this->powered;
	}

	public function setPowered(bool $powered) : void{
		$this->powered = $powered;
	}

	public function readSaveData(CompoundTag $nbt) : void{
		$this->customName = $nbt->getString(self::TAG_CUSTOM_NAME, "");
		$this->command = $nbt->getString(self::TAG_COMMAND, "");

		$this->executeOnFirstTick = $nbt->getByte(self::TAG_EXECUTE_ON_FIRST_TICK, 0) !== 0;
		$this->lpCommandMode = $nbt->getInt(self::TAG_LP_COMMAND_MODE, 0);
		$this->lpConditionalMode = $nbt->getByte(self::TAG_LP_CONDITIONAL_MODE, 0) !== 0;
		$this->lpRedstoneMode = $nbt->getByte(self::TAG_LP_REDSTONE_MODE, 0) !== 0;

		$this->lastExecution = $nbt->getLong(self::TAG_LAST_EXECUTION, 0);
		$this->lastOutput = $nbt->getString(self::TAG_LAST_OUTPUT, "");

		$this->successCount = $nbt->getInt(self::TAG_SUCCESS_COUNT, 0);
		$this->tickDelay = $nbt->getInt(self::TAG_TICK_DELAY, 0);

		$this->trackOutput = $nbt->getByte(self::TAG_TRACK_OUTPUT, 1) !== 0;

		$this->version = $nbt->getInt(self::TAG_VERSION, 34);

		$this->auto = $nbt->getByte(self::TAG_AUTO, 0) !== 0;
		$this->conditionMet = $nbt->getByte(self::TAG_CONDITION_MET, 0) !== 0;
		$this->isMovable = $nbt->getByte(self::TAG_IS_MOVABLE, 1) !== 0;
		$this->powered = $nbt->getByte(self::TAG_POWERED, 0) !== 0;
	}

	protected function writeSaveData(CompoundTag $nbt) : void{
		$nbt->setString(self::TAG_CUSTOM_NAME, $this->customName);
		$nbt->setString(self::TAG_COMMAND, $this->command);

		$nbt->setByte(self::TAG_EXECUTE_ON_FIRST_TICK, (int) $this->executeOnFirstTick);
		$nbt->setInt(self::TAG_LP_COMMAND_MODE, $this->lpCommandMode);
		$nbt->setByte(self::TAG_LP_CONDITIONAL_MODE, (int) $this->lpConditionalMode);
		$nbt->setByte(self::TAG_LP_REDSTONE_MODE, (int) $this->lpRedstoneMode);

		$nbt->setLong(self::TAG_LAST_EXECUTION, $this->lastExecution);
		$nbt->setString(self::TAG_LAST_OUTPUT, $this->lastOutput);

		$nbt->setInt(self::TAG_SUCCESS_COUNT, $this->successCount);
		$nbt->setInt(self::TAG_TICK_DELAY, $this->tickDelay);

		$nbt->setByte(self::TAG_TRACK_OUTPUT, (int) $this->trackOutput);

		$nbt->setInt(self::TAG_VERSION, $this->version);

		$nbt->setByte(self::TAG_AUTO, (int) $this->auto);
		$nbt->setByte(self::TAG_CONDITION_MET, (int) $this->conditionMet);
		$nbt->setByte(self::TAG_IS_MOVABLE, (int) $this->isMovable);
		$nbt->setByte(self::TAG_POWERED, (int) $this->powered);
	}

	protected function addAdditionalSpawnData(CompoundTag $nbt) : void{
		$nbt->setString(self::TAG_CUSTOM_NAME, $this->customName);
		$nbt->setString(self::TAG_COMMAND, $this->command);

		$nbt->setByte(self::TAG_EXECUTE_ON_FIRST_TICK, (int) $this->executeOnFirstTick);
		$nbt->setInt(self::TAG_LP_COMMAND_MODE, $this->lpCommandMode);
		$nbt->setByte(self::TAG_LP_CONDITIONAL_MODE, (int) $this->lpConditionalMode);
		$nbt->setByte(self::TAG_LP_REDSTONE_MODE, (int) $this->lpRedstoneMode);

		$nbt->setLong(self::TAG_LAST_EXECUTION, $this->lastExecution);
		$nbt->setString(self::TAG_LAST_OUTPUT, $this->lastOutput);

		$nbt->setInt(self::TAG_SUCCESS_COUNT, $this->successCount);
		$nbt->setInt(self::TAG_TICK_DELAY, $this->tickDelay);

		$nbt->setByte(self::TAG_TRACK_OUTPUT, (int) $this->trackOutput);

		$nbt->setInt(self::TAG_VERSION, $this->version);

		$nbt->setByte(self::TAG_AUTO, (int) $this->auto);
		$nbt->setByte(self::TAG_CONDITION_MET, (int) $this->conditionMet);
		$nbt->setByte(self::TAG_IS_MOVABLE, (int) $this->isMovable);
		$nbt->setByte(self::TAG_POWERED, (int) $this->powered);
	}

	public function getRealInventory() : Inventory{
		return $this->inventory;
	}

	public function getInventory() : Inventory{
		return $this->inventory;
	}
}
