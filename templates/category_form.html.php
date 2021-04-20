<form method="post">
	<input type="hidden" name="category[id]" value="<?= $category->id ?? '' ?>">
	<label for="category_name">Enter category name:</label>
	<input type="text" name="category[name]" value="<?= $category->name ?? '' ?>">
	<input type="submit" name="submit" value="Save">
</form>