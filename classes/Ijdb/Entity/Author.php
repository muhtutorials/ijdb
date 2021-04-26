<?php

namespace IJDB\Entity;
use Core\DatabaseTable;

class Author
{
	// binary
	const EDIT_JOKES = 1;
	const DELETE_JOKES = 2;
	const LIST_CATEGORIES = 4;
	const EDIT_CATEGORIES = 8;
	const DELETE_CATEGORIES = 16;
	const EDIT_USER_ACCESS = 32;

	public $id;
	public $name;
	public $email;
	public $password;
	public $permissions;
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
		return $this->jokesTable->save($joke);
	}

	// "&" is a bitwise "and" operator
	public function hasPermission($permission)
	{
		return $this->permissions & $permission;
	}
}
