<!DOCTYPE html>
<html lang="<?php echo $language->code ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
	<title>Admin page | Wuwana</title>
	<link rel="stylesheet" type="text/css" href="/static/css/admin.css">
	<script src="/static/admin.js" defer></script>
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="container">
		<?php include 'Templates/admin menu.php' ?>
		<div class="column-main">
			<section>
				<h2>Export database</h2>
				<div class="box pad-16">
					<a href="?export=user">Download table User</a><br>
					<a href="?export=company">Download table Company</a><br>
					<a href="?export=socialmedia">Download table SocialMedia</a><br>
					<a href="?export=image">Download table Image</a><br>
					<a href="?export=tag">Download table Tag</a><br>
				</div>
			</section>
			<section>
				<h2>Import database</h2>
				<div class="box pad-16">
					<form>
						<label for="f1">User table:</label><input id="f1" name="f1" type="file"><br>
						<label for="f2">Company table:</label><input id="f2" name="f2" type="file"><br>
						<label for="f3">SocialMedia table:</label><input id="f3" name="f3" type="file"><br>
						<label for="f4">Image table:</label><input id="f4" name="f4" type="file"><br>
						<label for="f5">Tag table:</label><input id="f5" name="f5" type="file"><br>
						<label for="f6">Category table:</label><input id="f6" name="f6" type="file"><br>
						<input type="submit">
					</form>
				</div>
			</section>
		</div>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>