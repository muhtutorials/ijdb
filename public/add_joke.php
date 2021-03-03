<?php

if (isset($_POST['text'])) {
	try {
		include __DIR__ . '/../includes/DatabaseConnection.php';
		include __DIR__ . '/../includes/DatabaseFunctions.php';

		insertJoke($pdo, ['text' => $_POST['text'], 'author_id' => 1]);

		header('Location: jokes.php');
	} catch (PDOException $e) {
		$title = 'An error occured';

		$output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ': ' . $e->getLine();
	}
} else {
	$title = 'Add a new joke';

	ob_start();

	include __DIR__ . '/../templates/add_joke.html.php';

	$output = ob_get_clean();
}

include __DIR__ . '/../templates/layout.html.php';
