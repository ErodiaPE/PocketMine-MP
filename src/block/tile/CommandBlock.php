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

	/**
	 * @param string $customName
	 *
	 * @return void
	 */
	public function setCustomName(string $customName) : void{
		$this->customName = $customName;
	}

	/**
	 * @return string
	 */
	public function getCommand() : string{
		return $this->command;
	}

	/**
	 * @param string $command
	 *
	 * @return void
	 */
	public function setCommand(string $command) : void{
		$this->command = $command;
	}

	/**
	 * @return bool
	 */
	public function isExecuteOnFirstTick() : bool{
		return $this->executeOnFirstTick;
	}

	/**
	 * @param bool $executeOnFirstTick
	 *
	 * @return void
	 */
	public function setExecuteOnFirstTick(bool $executeOnFirstTick) : void{
		$this->executeOnFirstTick = $executeOnFirstTick;
	}

	/**
	 * @return int
	 */
	public function getLPCommandMode() : int{
		return $this->lpCommandMode;
	}

	/**
	 * @param int $lpCommandMode
	 *
	 * @return void
	 */
	public function setLPCommandMode(int $lpCommandMode) : void{
		$this->lpCommandMode = $lpCommandMode;
	}

	/**
	 * @return bool
	 */
	public function isLPConditionalMode() : bool{
		return $this->lpConditionalMode;
	}

	/**
	 * @param bool $lpConditionalMode
	 *
	 * @return void
	 */
	public function setLPConditionalMode(bool $lpConditionalMode) : void{
		$this->lpConditionalMode = $lpConditionalMode;
	}

	/**
	 * @return bool
	 */
	public function isLPRedstoneMode() : bool{
		return $this->lpRedstoneMode;
	}

	/**
	 * @param bool $lpRedstoneMode
	 *
	 * @return void
	 */
	public function setLPRedstoneMode(bool $lpRedstoneMode) : void{
		$this->lpRedstoneMode = $lpRedstoneMode;
	}

	/**
	 * @return int
	 */
	public function getLastExecution() : int{
		return $this->lastExecution;
	}

	/**
	 * @param int $lastExecution
	 *
	 * @return void
	 */
	public function setLastExecution(int $lastExecution) : void{
		$this->lastExecution = $lastExecution;
	}

	/**
	 * @return string
	 */
	public function getLastOutput() : string{
		return $this->lastOutput;
	}

	/**
	 * @param string $lastOutput
	 *
	 * @return void
	 */
	public function setLastOutput(string $lastOutput) : void{
		$this->lastOutput = $lastOutput;
	}

	/**
	 * @return int
	 */
	public function getSuccessCount() : int{
		return $this->successCount;
	}

	/**
	 * @param int $successCount
	 *
	 * @return void
	 */
	public function setSuccessCount(int $successCount) : void{
		$this->successCount = $successCount;
	}

	/**
	 * @return int
	 */
	public function getTickDelay() : int{
		return $this->tickDelay;
	}

	/**
	 * @param int $tickDelay
	 *
	 * @return void
	 */
	public function setTickDelay(int $tickDelay) : void{
		$this->tickDelay = $tickDelay;
	}

	/**
	 * @return bool
	 */
	public function isTrackOutput() : bool{
		return $this->trackOutput;
	}

	/**
	 * @param bool $trackOutput
	 *
	 * @return void
	 */
	public function setTrackOutput(bool $trackOutput) : void{
		$this->trackOutput = $trackOutput;
	}

	/**
	 * @return int
	 */
	public function getVersion() : int{
		return $this->version;
	}

	/**
	 * @param int $version
	 *
	 * @return void
	 */
	public function setVersion(int $version) : void{
		$this->version = $version;
	}

	/**
	 * @return bool
	 */
	public function isAuto() : bool{
		return $this->auto;
	}

	/**
	 * @param bool $auto
	 *
	 * @return void
	 */
	public function setAuto(bool $auto) : void{
		$this->auto = $auto;
	}

	/**
	 * @return bool
	 */
	public function isConditionMet() : bool{
		return $this->conditionMet;
	}

	/**
	 * @param bool $conditionMet
	 *
	 * @return void
	 */
	public function setConditionMet(bool $conditionMet) : void{
		$this->conditionMet = $conditionMet;
	}

	/**
	 * @return bool
	 */
	public function isMovable() : bool{
		return $this->isMovable;
	}

	/**
	 * @param bool $isMovable
	 *
	 * @return void
	 */
	public function setMovable(bool $isMovable) : void{
		$this->isMovable = $isMovable;
	}

	/**
	 * @return bool
	 */
	public function isPowered() : bool{
		return $this->powered;
	}

	/**
	 * @param bool $powered
	 *
	 * @return void
	 */
	public function setPowered(bool $powered) : void{
		$this->powered = $powered;
	}

	/**
	 * @param CompoundTag $nbt
	 *
	 * @return void
	 */
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

	/**
	 * @param CompoundTag $nbt
	 *
	 * @return void
	 */
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

	/**
	 * @param CompoundTag $nbt
	 *
	 * @return void
	 */
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
