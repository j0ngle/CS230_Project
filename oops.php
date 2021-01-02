<!--
oops.php
	- any time an error happens (Sql failure, sql injection), the site gets directed here
	- this page also redirects to the home page
-->

<?php
	require 'includes/header.php';
?>

<main>
	<div class="container" align="center">
		<h1 style="margin-top: 50px;">Oops! Something went wrong</h1>
		<p style="margin-top: 25px;">Click <a href='index.php'>here</a> to return to the home page.</p>
	</div>
</main>