<?php

namespace Ijdb\Controllers;
use Core\DatabaseTable;
use Core\Authentication;

class Joke
{
	private $jokesTable;
	private $authorsTable;
	private $authentication;
	
	public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable, Authentication $authentication)
	{
		$this->jokesTable = $jokesTable;
		$this->authorsTable = $authorsTable;
		$this->authentication = $authentication;
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
				'author_id' => $author['id']
			];
		}

		$title = 'Joke list';

		$totalJokes = $this->jokesTable->total();

		$user = $this->authentication->getUser();

		return [
			'title' => $title,
			'template' => 'jokes',
			'variables' => [
				'jokes' => $jokes,
				'totalJokes' => $totalJokes,
				'user_id' => $user['id'] ?? null
			]
		];
	}

	public function form()
	{
		$user = $this->authentication->getUser();

		if (isset($_GET['id'])) {
			$joke = $this->jokesTable->findById($_GET['id']);
			$title = 'Edit joke';
		} else {
			$title = 'Add a new joke';
		}
		
		return [
			'title' => $title,
			'template' => 'joke_form',
			'variables' => [
				'joke' => $joke ?? null,
				'user_id' => $user['id'] ?? null
			]
		];
	}

	public function saveForm()
	{
		$user = $this->authentication->getUser();

		if (isset($_GET['id'])) {
			$joke = $this->jokesTable->findById($_GET['id']);

			if ($user['id'] !== $joke['author_id']) return;
		}

		$joke = $_POST['joke'];
		$joke['author_id'] = $user['id'];

		$this->jokesTable->save($joke);

		header('Location: /joke/list');
	} 

	public function delete()
	{
		$user = $this->authentication->getUser();

		$joke = $this->jokesTable->findById($_POST['id']);

		if ($user['id'] !== $joke['author_id']) return;
		
		$this->jokesTable->delete($_POST['id']);

		header('Location: /joke/list');
	}

	public function home()
	{
		$title = 'Internet Joke Database';

		return ['title' => $title, 'template' => 'home'];
	}
}
