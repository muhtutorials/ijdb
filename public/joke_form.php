<?php

include __DIR__ . '/../includes/DatabaseConnection.php';
include __DIR__ . '/../includes/DatabaseFunctions.php';

try {
	if (isset($_POST['joke'])) {
		$joke = $_POST['joke'];
		$joke['author_id'] = 1;

		save($pdo, 'joke', 'id', $joke);

		header('Location: jokes.php');
	} else {
		if (isset($_GET['id'])) {
			$joke = findById($pdo, 'joke', 'id', $_GET['id']);
			$title = 'Edit joke';
		} else {
			$title = 'Add a new joke';
		}

		ob_start();

		include __DIR__ . '/../templates/joke_form.html.php';

		$output = ob_get_clean();
	}
} catch (PDOException $e) {
		$title = 'An error occured';

		$output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ': ' . $e->getLine();
}

include __DIR__ . '/../templates/layout.html.php';
