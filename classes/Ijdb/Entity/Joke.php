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
	private $author;

	public function __construct(DatabaseTable $authorsTable)
	{
		$this->authorsTable = $authorsTable;
	}

	// caches the result
	public function getAuthor()
	{
		if (empty($this->author)) {
			$this->author = $this->authorsTable->findById($this->author_id);
		}

		return $this->author;
	}
}