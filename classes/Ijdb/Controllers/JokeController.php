<?php

namespace Ijdb\Controllers;
use Core\DatabaseTable;
use Core\Authentication;
use Ijdb\Entity\Author;

class JokeController
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
		$jokes = $this->jokesTable->findAll();

		$title = 'Joke list';

		$totalJokes = $this->jokesTable->total();

		$user = $this->authentication->getUser();

		return [
			'title' => $title,
			'template' => 'jokes',
			'variables' => [
				'jokes' => $jokes,
				'totalJokes' => $totalJokes,
				'user_id' => $user->id ?? null
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
				'user_id' => $user->id ?? null
			]
		];
	}

	public function saveForm()
	{
		$author = $this->authentication->getUser(); 

		if (isset($_GET['id'])) {
			$joke = $this->jokesTable->findById($_GET['id']);

			if ($author->id !== $joke->author_id) return;
		}

		$joke = $_POST['joke'];
		
		$author->addJoke($joke);

		header('Location: /joke/list');
	} 

	public function delete()
	{
		$user = $this->authentication->getUser();

		$joke = $this->jokesTable->findById($_POST['id']);
		echo $joke->id;
		if ($user->id !== $joke->author_id) return;

		$this->jokesTable->delete($_POST['id']);

		header('Location: /joke/list');
	}

	public function home()
	{
		$title = 'Internet Joke Database';

		return ['title' => $title, 'template' => 'home'];
	}
}
