<?php

try {
	include __DIR__ . '/../includes/DatabaseConnection.php';
	include __DIR__ . '/../includes/DatabaseFunctions.php';

	$jokes = allJokes($pdo);

	$title = 'Joke list';

	$totalJokes = totalJokes($pdo);

	ob_start();

	include __DIR__ . '/../templates/jokes.html.php';

	$output = ob_get_clean();
} catch (PDOException $e) {
	$title = 'An error occured';
	$output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ': ' . $e->getLine();
}

include __DIR__ . '/../templates/layout.html.php';
