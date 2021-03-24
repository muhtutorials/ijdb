<?php if (!empty($errors)): ?>
	<div class="errors">
		<p>Your account couldn't be created. Please check the following:</p>
		<ul>
			<?php foreach ($errors as $error): ?>
				<li><?= $error ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>

<form method="post">
	<label for="name">Your name</label>
	<input type="text" id="name" name="author[name]" value="<?= $author['name'] ?? '' ?>">

	<label for="email">Your email address</label>
	<input type="email" id="email" name="author[email]" value="<?= $author['email'] ?? '' ?>">

	<label for="password">Password</label>
	<input type="password" id="password" name="author[password]">

	<input type="submit" name="submit" value="Submit">
</form>
