<?php 
	if (isset($error)) echo '<div class="errors">' . $error . '</div>';
?>

<form method="post">
	<label for="email">Your email address</label>
	<input type="email" id="email" name="email" value="<?= $author['email'] ?? '' ?>">

	<label for="password">Password</label>
	<input type="password" id="password" name="password">

	<input type="submit" name="submit" value="Submit">
</form>

<p>Don't have an account? <a href="/author/register">Click here to register</a></p>
