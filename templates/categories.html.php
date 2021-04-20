<h2>Categories</h2>

<a href="/category/form">Add a new category</a>

<?php foreach ($categories as $category): ?>

<blockquote>
	<p>
		<?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8') ?>
 
		<a href="/category/form?id=<?= $category->id ?>">Edit</a>
	</p>

	<form action="/category/delete" method="post">
		<input type="hidden" name="id" value="<?= $category->id ?>">
		<input type="submit" value="Delete">
	</form>
</blockquote>

<?php endforeach; ?>
