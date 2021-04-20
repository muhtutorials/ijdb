<?php

namespace Ijdb\Controllers;
use Core\DatabaseTable;

class CategoryController
{
	private $categoriesTable;

	public function __construct(DatabaseTable $categoriesTable)
	{
		$this->categoriesTable = $categoriesTable;
	}

	public function list()
	{
		$categories = $this->categoriesTable->findAll();

		$title = 'Category list';

		return [
			'title' => $title,
			'template' => 'categories',
			'variables' => [
				'categories' => $categories,
			]
		];
	}

	public function form()
	{
		if (isset($_GET['id'])) {
			$category = $this->categoriesTable->findById($_GET['id']);
		}

		$title = 'Edit category';

		return [
			'title' => $title,
			'template' => 'category_form',
			'variables' => [
				'category' => $category ?? null,
			]
		];
	}

	public function saveForm()
	{

		$category = $_POST['category'];
		
		$this->categoriesTable->save($category);

		header('Location: /category/list');
	} 

	public function delete()
	{
		$this->categoriesTable->delete($_POST['id']);

		header('Location: /category/list');
	}
}
