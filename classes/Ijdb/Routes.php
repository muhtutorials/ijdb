<?php

namespace Ijdb;
use Ijdb\RoutesInterface;
use Core\DatabaseTable;
use Ijdb\Controllers\Joke;

class Routes implements RoutesInterface
{
	public function getRoutes()
	{
		include __DIR__ . '/../../includes/DatabaseConnection.php';

		$jokesTable = new DatabaseTable($pdo, 'joke', 'id');
		$authorsTable = new DatabaseTable($pdo, 'author', 'id');

		$jokeController = new Joke($jokesTable, $authorsTable);

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
			],
			'joke/delete' => [
				'POST' => [
					'controller' => $jokeController,
					'action' => 'delete'
				]
			],
		];

		return $routes;		
	}
}
