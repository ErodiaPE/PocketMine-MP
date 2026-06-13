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

namespace pocketmine\build\generate_stuff;

use function dirname;
use function fclose;
use function proc_close;
use function proc_open;
use function stream_get_contents;

require dirname(__DIR__) . '/vendor/autoload.php';

function send(string $path, string $cwd = null) {
	$cwd ??= dirname(__DIR__); // root projet

	$descriptors = [
		1 => ["pipe", "w"],
		2 => ["pipe", "w"]
	];

	$process = proc_open(
		"php " . $path,
		$descriptors,
		$pipes,
		$cwd
	);

	$output = stream_get_contents($pipes[1]);
	$error = stream_get_contents($pipes[2]);

	fclose($pipes[1]);
	fclose($pipes[2]);

	$code = proc_close($process);

	echo $path . ":\n";
	echo $output;

	if ($error) {
		echo "\n[ERROR]\n" . $error;
	}
}

send(".\build\codegen\\registry-interface.php .\src\ .\generated\\");
send(".\build\codegen\\item-block-type-ids.php");
