<?php

namespace Core;

class EntryPoint
{
	private $route;
	private $method;
	private $routes;

	public function __construct(string $route, string $method, $routes)
	{
		$this->route = $route;
		$this->method = $method;
		$this->routes = $routes;
		$this->checkUrl();
	}

	private function checkUrl()
	{
		if ($this->route !== strtolower($this->route)) {
			// set response code to 301 to let browser and search engine know that redirect is permanent
			// tells search engine not to list the page
			http_response_code(301);
			header('location: ' . strtolower($this->route));
		}
	}

	private function loadTemplate($templateName, $variables)
	{
		extract($variables);

		ob_start();

		include __DIR__ . "/../../templates/$templateName.html.php";

		return $output = ob_get_clean();	
	}

	public function run()
	{
		$routes = $this->routes->getRoutes();
		$controller = $routes[$this->route][$this->method]['controller'];
		$action = $routes[$this->route][$this->method]['action'];
		
		$page = $controller->$action();

		$title = $page['title'];

		$output = $this->loadTemplate($page['template'], $page['variables'] ?? []);

		include __DIR__ . '/../../templates/layout.html.php';
	}
}
