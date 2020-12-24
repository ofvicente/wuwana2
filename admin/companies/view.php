<!DOCTYPE html>
<html lang="<?php echo $language ?>">
<head>
	<?php include '../../Templates/page metadata.php' ?>
	<title>Admin page | Wuwana</title>
	<link rel="stylesheet" type="text/css" href="/static/admin.css">
	<script src="/static/admin.js" defer></script>
</head>
<body>
	<?php include '../../Templates/page header.php' ?>
	<div class="Container">
		<?php include '../../Templates/admin menu.php' ?>
		<div class="ColumnMain">
			<section>
				<h2>New company</h2>
				<div class="Box">
					<form method="post">
						<label for="instagram">Instagram profile URL:</label>
						<input id="instagram" name="instagram" type="text" size="70" onchange="scrape()">
						<br>
						<label for="website">Website URL:</label>
						<input id="website" name="website" type="text" size="79">
						<br>
						<label for="email">Email address:</label>
						<input id="email" name="email" type="text" size="77">
						<br>
						<label for="name">Company name:</label>
						<input id="name" name="name" type="text" size="75">
						<br>
						<textarea id="biography" name="biography" rows="9" cols="90"></textarea>
						<br>
						<input type="text" id="posts" name="posts" size="9" readonly>posts
						<input type="text" id="followers" name="followers" size="9" style="margin-left:73px" readonly>followers
						<input type="text" id="following" name="following" size="9" style="margin-left:73px" readonly>following
						<input type="hidden" id="ProfilePicURL" name="ProfilePicURL">
						<input type="hidden" id="ThumbnailSrc0" name="ThumbnailSrc0">
						<input type="hidden" id="ThumbnailSrc1" name="ThumbnailSrc1">
						<input type="hidden" id="ThumbnailSrc2" name="ThumbnailSrc2">
						<input type="hidden" id="ThumbnailSrc3" name="ThumbnailSrc3">
						<input type="hidden" id="ThumbnailSrc4" name="ThumbnailSrc4">
						<input type="hidden" id="ThumbnailSrc5" name="ThumbnailSrc5">
						<input type="hidden" id="ExternalURL" name="ExternalURL">
						<input type="hidden" id="ExtraInfo" name="ExtraInfo">
						<input type="submit" id="button" value="Add" style="margin-left:73px" disabled>
					</form>
				</div>
			</section>
			<section>
				<h2>Companies</h2>
				<div class="Box">
					<table>
						<thead>
							<tr>
								<th>Name</th>
								<th>Description</th>
								<th>Location</th>
								<th>Visible tags</th>
								<th>Last update</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach ($companies as $company)
								{
									echo '<tr>';
									echo   '<td><a href="', WebApp\WebApp::getHostname(), '/', $company->permalink, '">';
									echo     $company->name;
									echo   '</a></td>';
									echo   '<td title="', $company->description, '">', substr($company->description,0,9), '…</td>';
									echo   '<td>', $company->region, '</td>';
									echo   '<td title="Other tags: ', $company->otherTags, '">';
									echo     implode(' ', $company->visibleTags);
									echo   '</td>';
									echo   '<td>', date('Y-m-d H:i', $company->lastUpdate), '</td>';
									echo   '<td><input type="button" value="Delete" disabled></td>';
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
			</section>
		</div>
	</div>
	<?php include '../../Templates/page footer.php' ?>
</body>
</html>