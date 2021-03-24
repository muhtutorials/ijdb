<h2><?= isset($_GET['id']) ? 'Edit your joke' : 'Add a new joke' ?></h2>

<?php if (!isset($_GET['id']) || $user_id === $joke['author_id']): ?>
	<form method="post">
		<input type="hidden" name="joke[id]" value="<?= $joke['id'] ?? '' ?>">
		<textarea
			id="text"
			name="joke[text]"
			rows="3"
			cols="40"
			placeholder="Type your joke here..."
		><?= $joke['text'] ?? '' ?></textarea>
		<input type="submit" name="submit" value="Save">
	</form>
<?php else: ?>
	<p>You may only edit jokes that you posted</p>
<?php endif; ?>