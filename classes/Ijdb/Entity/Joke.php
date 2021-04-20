<?php

namespace IJDB\Entity;
use Core\DatabaseTable;

class Joke
{
	public $id;
	public $text;
	public $timestamp;
	public $author_id;
	private $authorsTable;
	private $jokeCategoriesTable;
	private $author;

	public function __construct(DatabaseTable $authorsTable, DatabaseTable $jokeCategoriesTable)
	{
		$this->authorsTable = $authorsTable;
		$this->jokeCategoriesTable = $jokeCategoriesTable;
	}

	// caches the result
	public function getAuthor()
	{
		if (empty($this->author)) {
			$this->author = $this->authorsTable->findById($this->author_id);
		}

		return $this->author;
	}

	public function addCategory($categoryId)
	{
		$jokeCategory = ['joke_id' => $this->id, 'category_id' => $categoryId];

		$this->jokeCategoriesTable->save($jokeCategory);
	}

	public function hasCategory($categoryId)
	{
		$jokeCategories = $this->jokeCategoriesTable->find('joke_id', $this->id);

		foreach ($jokeCategories as $jokeCategory) {
			if ($jokeCategory->category_id == $categoryId) return true;
		}
	}

	public function clearCategories()
	{
		$this->jokeCategoriesTable->deleteWhere('joke_id', $this->id);
	}
}