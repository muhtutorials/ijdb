<?php

include __DIR__ . '/../includes/DatabaseConnection.php';
include __DIR__ . '/../includes/DatabaseFunctions.php';

try {
	if (isset($_POST['text'])) {
		updateJoke($pdo, ['id' => $_POST['id'], 'text' => $_POST['text'], 'author_id' => 1]);

		header('Location: jokes.php');
	} else {
		$joke = getJoke($pdo, $_GET['id']);

		$title = 'Edit joke';

		ob_start();

		include __DIR__ . '/../templates/edit_joke.html.php';

		$output = ob_get_clean();
	}
} catch (PDOException $e) {
		$title = 'An error occured';

		$output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ': ' . $e->getLine();
}

include __DIR__ . '/../templates/layout.html.php';
