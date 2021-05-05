<?php

namespace Ijdb\Controllers;
use Core\DatabaseTable;
use Core\Authentication;
use Ijdb\Entity\Author;

class JokeController
{
	private $jokesTable;
	private $authorsTable;
	private $categoriesTable;
	private $authentication;
	
	public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable, DatabaseTable $categoriesTable, Authentication $authentication)
	{
		$this->jokesTable = $jokesTable;
		$this->authorsTable = $authorsTable;
		$this->categoriesTable = $categoriesTable;
		$this->authentication = $authentication;
	}

	public function list()
	{
		$page = $_GET['page'] ?? 1;

		$offset = ($page - 1) * 10;

		if (isset($_GET['category'])) {
			$category = $this->categoriesTable->findById($_GET['category']);

			$jokes = $category->getJokes(10, $offset);

			$totalJokes = $category->getNumJokes();
		} else {
			$jokes = $this->jokesTable->findAll('timestamp DESC', 10, $offset);

			$totalJokes = $this->jokesTable->total();
		}
		
		$title = 'Joke list';

		$user = $this->authentication->getUser() ?? null;

		$categories = $this->categoriesTable->findAll();

		return [
			'title' => $title,
			'template' => 'jokes',
			'variables' => [
				'jokes' => $jokes,
				'totalJokes' => $totalJokes,
				'user' => $user,
				'categories' => $categories,
				'currentPage' => $page,
				'categoryId' => $_GET['category'] ?? null
			]
		];
	}

	public function form()
	{
		$user = $this->authentication->getUser();
		$categories = $this->categoriesTable->findAll();

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
				'user' => $user ?? null,
				'categories' => $categories
			]
		];
	}

	public function saveForm()
	{
		$author = $this->authentication->getUser(); 

		if (isset($_GET['id'])) {
			$joke = $this->jokesTable->findById($_GET['id']);

			if ($author->id !== $joke->author_id && !$author->hasPermission(Author::EDIT_JOKES)) return;
		}

		$joke = $_POST['joke'];
		$categories = $_POST['categories'];
		
		$jokeEntity = $author->addJoke($joke);
		$jokeEntity->clearCategories();

		foreach ($categories as $categoryId) {
			$jokeEntity->addCategory($categoryId);
		}

		header('Location: /joke/list');
	} 

	public function delete()
	{
		$user = $this->authentication->getUser();

		$joke = $this->jokesTable->findById($_POST['id']);
		
		if ($user->id !== $joke->author_id && !$user->hasPermission(Author::DELETE_JOKES)) return;

		$this->jokesTable->delete($_POST['id']);

		header('Location: /joke/list');
	}

	public function home()
	{
		$title = 'Internet Joke Database';

		return ['title' => $title, 'template' => 'home'];
	}
}
