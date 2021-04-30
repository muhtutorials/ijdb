<div class="joke-list">

	<ul class="categories">
		<?php if ($user && $user->hasPermission(\Ijdb\Entity\Author::LIST_CATEGORIES)): ?>
			<li class="categories-edit"><a href="/category/list">Edit categories</a></li>
		<?php endif; ?>
		<?php foreach ($categories as $category): ?>
			<li><a href="/joke/list?category=<?= $category->id ?>"><?= $category->name ?></a></li>
		<?php endforeach; ?>
	</ul>		

	<div class="jokes">
		<p><?= $totalJokes ?> jokes have been submitted to the Internet Joke Database</p>

		<?php foreach ($jokes as $joke): ?>

			<blockquote>
				<div>
					<?= (new \Core\Markdown($joke->text))->toHtml() ?>
					(by <a href="mailto:<?= htmlspecialchars($joke->getAuthor()->email, ENT_QUOTES, 'UTF-8') ?>"
						><?= htmlspecialchars($joke->getAuthor()->name, ENT_QUOTES, 'UTF-8') ?>
						</a> on <?php
									$date = new DateTime($joke->timestamp);
									echo $date->format('jS F Y');
								?>) 
				<?php if ($user): ?>
					<?php if ($user->id === $joke->author_id || $user->hasPermission(\Ijdb\Entity\Author::EDIT_JOKES)): ?>
						<a href="/joke/form?id=<?= $joke->id ?>">Edit</a>
					<?php endif; ?>
				</div>

					<?php if ($user->id === $joke->author_id || $user->hasPermission(\Ijdb\Entity\Author::DELETE_JOKES)): ?>
						<form action="/joke/delete" method="post">
							<input type="hidden" name="id" value="<?= $joke->id ?>">
							<input type="submit" value="Delete">
						</form>
					<?php endif; ?>
				<?php else: ?>
				</div>
				<?php endif; ?>
			</blockquote>

		<?php endforeach; ?>
	</div>
</div>
