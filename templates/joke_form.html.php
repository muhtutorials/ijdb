<h2><?= isset($_GET['id']) ? 'Edit your joke' : 'Add a new joke' ?></h2>

<?php if (!isset($_GET['id']) || $user_id === $joke->author_id): ?>
	<form method="post">
		<input type="hidden" name="joke[id]" value="<?= $joke->id ?? '' ?>">
		<textarea
			id="text"
			name="joke[text]"
			rows="3"
			cols="40"
			placeholder="Type your joke here..."
		><?= $joke->text ?? '' ?></textarea>

		<p>Select categories for this joke</p>

		<?php foreach ($categories as $category): ?>
			<div>
				<?php if ($joke && $joke->hasCategory($category->id)): ?>
					<input type="checkbox" name="categories[]" value="<?= $category->id ?>" checked />
				<?php else: ?>
					<input type="checkbox" name="categories[]" value="<?= $category->id ?>" />
				<?php endif; ?>
				<label><?= $category->name ?></label>					
			</div>
		<?php endforeach; ?>

		<input type="submit" name="submit" value="Save">
	</form>
<?php else: ?>
	<p>You may only edit jokes that you posted</p>
<?php endif; ?>