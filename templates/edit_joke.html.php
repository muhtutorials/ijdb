<h2>Edit your joke</h2>

<form method="post">
	<input type="hidden" name="id" value="<?= $joke['id'] ?>">
	<textarea
		id="text"
		name="text"
		rows="3"
		cols="40"
		placeholder="Type your joke here:"
	><?= $joke['text'] ?></textarea>
	<input type="submit" name="submit" value="Save">
</form>
