<?php

try {
	include __DIR__ . '/../includes/DatabaseConnection.php';
	include __DIR__ . '/../includes/DatabaseFunctions.php';

	$result = findAll($pdo, 'joke');
	$jokes = [];

	foreach ($result as $joke) {
		$author = findById($pdo, 'author', 'id', $joke['author_id']);

		$jokes[] = [
			'id' => $joke['id'],
			'text' => $joke['text'],
			'timestamp' => $joke['timestamp'],
			'name' => $author['name'],
			'email' => $author['email'],
		];
	}

	$title = 'Joke list';

	$totalJokes = total($pdo, 'joke');

	ob_start();

	include __DIR__ . '/../templates/jokes.html.php';

	$output = ob_get_clean();
} catch (PDOException $e) {
	$title = 'An error occured';
	$output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ': ' . $e->getLine();
}

include __DIR__ . '/../templates/layout.html.php';
