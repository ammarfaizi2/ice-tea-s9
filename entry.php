<?php
// SPDX-License-Identifier: GPL-2.0-only

require __DIR__."/config.php";

use IceTeaS9\IceTea;

function ict_autoloader(string $class_name)
{
	$class_name = str_replace("\\", "/", $class_name);
	$file = __DIR__."/src/{$class_name}.php";
	if (file_exists($file)) {
		require $file;
		return true;
	}

	return false;
}

function ict_init()
{
	spl_autoload_register("ict_autoloader");
}

function main()
{
	ict_init();

	$http = new Swoole\Http\Server("127.0.0.1", 9501);
	$http->set(["hook_flags" => SWOOLE_HOOK_ALL]);
	$http->on("request", function ($request, $response) {
		$ic = new IceTea($request->getContent());
		$ic->execute();
		$response->setHeader("Content-Type", "text/plain");
		$response->end("OK!");
	});
	$http->start();
	return 0;
}

exit(main());
