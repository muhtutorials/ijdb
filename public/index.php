<?php

function loadTemplate($templateName, $variables)
{
	extract($variables);

	ob_start();

	include __DIR__ . "/../templates/$templateName.html.php";

	return $output = ob_get_clean();	
}

try {
	include __DIR__ . '/../includes/DatabaseConnection.php';
	include __DIR__ . '/../classes/DatabaseTable.php';
	include __DIR__ . '/../controllers/JokeController.php';

	$jokesTable = new DatabaseTable($pdo, 'joke', 'id');
	$authorsTable = new DatabaseTable($pdo, 'author', 'id');

	$jokeController = new JokeController($jokesTable, $authorsTable);

	$action = $_GET['action'] ?? 'home';

	$page = $jokeController->$action();

	$title = $page['title'];

	$output = loadTemplate($page['template'], $page['variables'] ?? []);

} catch (PDOException $e) {
		$title = 'An error occured';

		$output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ': ' . $e->getLine();
}

include __DIR__ . '/../templates/layout.html.php';
