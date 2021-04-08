<?php

namespace Ijdb\Controllers;
use Core\DatabaseTable;

class RegisterController
{
	private $authorsTable;
	
	public function __construct(DatabaseTable $authorsTable)
	{
		$this->authorsTable = $authorsTable;
	}

	public function registrationForm()
	{
		return ['title' => 'Register an account', 'template' => 'register'];
	}

	public function success()
	{
		return ['title' => 'Registration Successful', 'template' => 'register_success'];
	}

	public function registerUser()
	{
		$author = $_POST['author'];

		$valid = true;
		$errors = [];

		if (empty($author['name'])) {
			$valid = false;
			$errors[] = 'Name cannot be blank';
		}

		if (empty($author['email'])) {
			$valid = false;
			$errors[] = 'Email cannot be blank';
		} elseif (!filter_var($author['email'], FILTER_VALIDATE_EMAIL)) {
			$valid = false;
			$errors[] = 'Invalid email address';
		} else {
			if (count($this->authorsTable->find('email', strtolower($author['email']))) > 0) {
				$valid = false;
				$errors[] = 'Email address already exists';
			}
		}

		if (empty($author['password'])) {
			$valid = false;
			$errors[] = 'Password cannot be blank';
		}

		if ($valid) {
			$author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);
			
			$this->authorsTable->save($author);

			header('Location: /author/success');		
		} else {
			return [
				'title' => 'Register an account',
				'template' => 'register',
				'variables' => [
					'author' => $author,
					'errors' => $errors
				]
			];
		}
	}
}