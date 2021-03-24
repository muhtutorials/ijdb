<p><?= $totalJokes ?> jokes have been submitted to the Internet Joke Database</p>

<?php foreach ($jokes as $joke): ?>

<blockquote>
	<p>
		<?= htmlspecialchars($joke['text'], ENT_QUOTES, 'UTF-8') ?>

		(by <a href="mailto:<?= htmlspecialchars($joke['email'], ENT_QUOTES, 'UTF-8') ?>
"><?= htmlspecialchars($joke['name'], ENT_QUOTES, 'UTF-8') ?>
</a> on <?php
			$date = new DateTime($joke['timestamp']);
			echo $date->format('jS F Y');
 			
		?>) 
<?php if ($user_id === $joke['author_id']): ?> 
		<a href="/joke/form?id=<?= $joke['id'] ?>">Edit</a>
	</p>

	<form action="/joke/delete" method="post">
		<input type="hidden" name="id" value="<?= $joke['id'] ?>">
		<input type="submit" value="Delete">
	</form>
<?php else: ?>
	</p>
<?php endif; ?>

</blockquote>

<?php endforeach; ?>
