<?php

namespace Core;

class Authentication
{
	private $users;
	private $usernameColumn;
	private $passwordColumn;

	public function __construct(DatabaseTable $users, $usernameColumn, $passwordColumn)
	{
		session_start();
		$this->users = $users;
		$this->usernameColumn = $usernameColumn;
		$this->passwordColumn = $passwordColumn;
	}

	public function login($username, $password)
	{
		$user = $this->users->find($this->usernameColumn, strtolower($username));

		if (!empty($user) && password_verify($password, $user[0][$this->passwordColumn])) {
			// security measure in case a hacker got hold of session ID before user logged in
			session_regenerate_id();
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $user[0][$this->passwordColumn];
			return true;
		}

		return false;
	}

	public function isLoggedIn()
	{
		if (empty($_SESSION['username'])) return false;

		$user = $this->users->find($this->usernameColumn, strtolower($_SESSION['username']));
		
		if (!empty($user) && $user[0][$this->passwordColumn] === $_SESSION['password']) return true;
		
		return false;
	}

	public function getUser() {
		if ($this->isLoggedIn()) {
			return $this->users->find($this->usernameColumn, strtolower($_SESSION['username']))[0];
		}

		return false;
	}
}