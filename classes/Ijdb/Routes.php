<?php

namespace Ijdb;
use Ijdb\RoutesInterface;
use Core\DatabaseTable;
use Ijdb\Controllers\Joke;
use Ijdb\Controllers\Register;
use Ijdb\Controllers\Login;
use Core\Authentication;

class Routes implements RoutesInterface
{
	private $jokesTable;
	private $authorsTable;
	private $authentication;

	public function __construct()
	{
		include __DIR__ . '/../../includes/DatabaseConnection.php';

		$this->jokesTable = new DatabaseTable($pdo, 'joke', 'id');
		$this->authorsTable = new DatabaseTable($pdo, 'author', 'id');

		$this->authentication = new Authentication($this->authorsTable, 'email', 'password');
	}

	public function getRoutes(): array
	{
		$jokeController = new Joke($this->jokesTable, $this->authorsTable, $this->authentication);
		$authorController = new Register($this->authorsTable);
		$loginController = new Login($this->authentication);

		$routes = [	
			'' => [
				'GET' => [
					'controller' => $jokeController,
					'action' => 'home'
				]
			],
			'joke/list' => [
				'GET' => [
					'controller' => $jokeController,
					'action' => 'list'
				]
			],
			'joke/form' => [
				'GET' => [
					'controller' => $jokeController,
					'action' => 'form'
				],
				'POST' => [
					'controller' => $jokeController,
					'action' => 'saveForm'
				],
				'login' => true			
			],
			'joke/delete' => [
				'POST' => [
					'controller' => $jokeController,
					'action' => 'delete'
				],
				'login' => true
			],
			'author/register' => [
				'GET' => [
					'controller' => $authorController,
					'action' => 'registrationForm'
				],
				'POST' => [
					'controller' => $authorController,
					'action' => 'registerUser'
				]
			],
			'author/success' => [
				'GET' => [
					'controller' => $authorController,
					'action' => 'success'
				]
			],
			'login' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'loginForm'
				],
				'POST' => [
					'controller' => $loginController,
					'action' => 'loginUser'
				]
			],
			'login/success' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'success'
				],
				'login' => true
			],						
			'login/required' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'required'
				]
			],
			'logout' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'logout'
				]
			]
		];

		return $routes;		
	}

	public function getAuthentication(): Authentication
	{
		return $this->authentication;
	}
}
