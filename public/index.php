<?php

use Core\EntryPoint;
use Ijdb\Routes;

try {
	include __DIR__ . '/../includes/autoload.php';

	$route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
	$method = $_SERVER['REQUEST_METHOD'];
	$routes = new Routes();

	$entryPoint = new EntryPoint($route, $method, $routes);
	$entryPoint->run();
} catch (\PDOException $e) {
		$title = 'An error occured';

		$output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ': ' . $e->getLine();
		include __DIR__ . '/../templates/layout.html.php';
}
