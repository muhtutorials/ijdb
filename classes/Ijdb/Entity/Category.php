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

	public function getJokes($limit = null, $offset = null)
	{
		$jokeCategories = $this->jokeCategoriesTable->find('category_id', $this->id, null, $limit, $offset);

		$jokes = [];

		foreach ($jokeCategories as $jokeCategory) {
			$joke = $this->jokesTable->findById($jokeCategory->joke_id);

			if ($joke) $jokes[] = $joke;
		}

		usort($jokes, [$this, 'sortJokes']);

		return $jokes;
	}

	private function sortJokes($a, $b)
	{
		$aDate = new \Datetime($a->timestamp);
		$bDate = new \Datetime($b->timestamp);

		if ($aDate->getTimestamp() == $bDate->getTimestamp()) return 0;

		return $aDate->getTimestamp() > $bDate->getTimestamp() ? -1 : 1;
	}

	public function getNumJokes()
	{
		return $this->jokeCategoriesTable->total('category_id', $this->id);
	}
}