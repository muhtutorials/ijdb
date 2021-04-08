<?php

namespace IJDB\Entity;
use Core\DatabaseTable;

class Author
{
	public $id;
	public $name;
	public $email;
	public $password;
	private $jokesTable; 

	public function __construct(DatabaseTable $jokesTable)
	{
		$this->jokesTable = $jokesTable;
	}

	public function getJokes()
	{
		return $this->jokesTable->find('author_id', $this->id);
	}

	public function addJoke($joke)
	{
		$joke['author_id'] = $this->id;
		$this->jokesTable->save($joke);
	}
}
