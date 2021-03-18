<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/styles.css">
	<title><?= $title ?></title>
</head>
<body>
	<nav>
		<header>
			<h1>Internet Joke Database</h1>
		</header>
		<ul class="navbar">
			<li><a href="/">Home</a></li>
			<li><a href="/joke/list">Jokes</a></li>
			<li><a href="/joke/form">Add a new joke</a></li>
		</ul>
	</nav>

	<main>
		<?= $output ?>
	</main>

	<footer>
		&copy; IJDB 2021
	</footer>
</body>
</html>
