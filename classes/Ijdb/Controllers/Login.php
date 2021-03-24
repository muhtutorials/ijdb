<?php

namespace Ijdb\Controllers;
use Core\Authentication;

class Login
{
	private $authentication;

	public function __construct(Authentication $authentication)
	{
		$this->authentication = $authentication;
	}

	public function loginForm()
	{
		return ['title' => 'Log in', 'template' => 'login'];		
	}

	public function loginUser()
	{
		if ($this->authentication->login($_POST['email'], $_POST['password'])) {
			header('Location: /login/success');
		} else {
			return [
				'title' => 'Log in',
				'template' => 'login',
				'variables' => ['error' => 'Invalid username or password']
			];
		}		
	}

	public function success()
	{
		return ['title' => 'Login successful', 'template' => 'login_success'];		
	}

	public function required()
	{
		return ['title' => 'You are not logged in', 'template' => 'login_required'];
	}

	public function logout()
	{
		$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', time() - 42000,
		        $params["path"], $params["domain"],
		        $params["secure"], $params["httponly"]
		    );
		}

		// Finally, destroy the session.
		session_destroy();
		
		return ['title' => 'You have been logged out', 'template' => 'logout'];
	}
}
