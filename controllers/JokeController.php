<?php

class JokeController
{
	private $jokesTable;
	private $authorsTable;
	
	public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable)
	{
		$this->jokesTable = $jokesTable;
		$this->authorsTable = $authorsTable;
	}

	public function list()
	{
		$result = $this->jokesTable->findAll();
		$jokes = [];

		foreach ($result as $joke) {
			$author = $this->authorsTable->findById($joke['author_id']);

			$jokes[] = [
				'id' => $joke['id'],
				'text' => $joke['text'],
				'timestamp' => $joke['timestamp'],
				'name' => $author['name'],
				'email' => $author['email'],
			];
		}

		$title = 'Joke list';

		$totalJokes = $this->jokesTable->total();

		return [
			'title' => $title,
			'template' => 'jokes',
			'variables' => [
				'jokes' => $jokes,
				'totalJokes' => $totalJokes
			]
		];
	}

	public function form()
	{
		if (isset($_POST['joke'])) {
			$joke = $_POST['joke'];
			$joke['author_id'] = 1;

			$this->jokesTable->save($joke);

			header('Location: index.php?action=list');
		} else {
			if (isset($_GET['id'])) {
				$joke = $this->jokesTable->findById($_GET['id']);
				$title = 'Edit joke';
			} else {
				$title = 'Add a new joke';
			}
		}

		return [
			'title' => $title,
			'template' => 'joke_form',
			'variables' => [
				'joke' => $joke ?? null,
			]
		];
	}

	public function delete()
	{
		$this->jokesTable->delete($_POST['id']);

		header('Location: index.php?action=list');
	}

	public function home()
	{
		$title = 'Internet Joke Database';

		return ['title' => $title, 'template' => 'home'];
	}
}
