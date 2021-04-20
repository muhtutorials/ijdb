<?php

namespace IJDB\Entity;
use Core\DatabaseTable;

class Category
{
	public $id;
	public $name;
	private $jokesTable;
	private $jokeCategoriesTable;

	public function __construct(DatabaseTable $jokesTable, DatabaseTable $jokeCategoriesTable)
	{
		$this->jokesTable = $jokesTable;
		$this->jokeCategoriesTable = $jokeCategoriesTable;
	}

	public function getJokes()
	{
		$jokeCategories = $this->jokeCategoriesTable->find('category_id', $this->id);

		$jokes = [];

		foreach ($jokeCategories as $jokeCategory) {
			$joke = $this->jokesTable->findById($jokeCategory->joke_id);

			if ($joke) $jokes[] = $joke;
		}

		return $jokes;
	}
}