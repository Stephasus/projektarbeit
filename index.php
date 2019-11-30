<?php
$update = false;
$sendeEmail = false;
require_once("update.php");

if (isset($_POST["pagetitel"]) && isset($_POST["link"])) {
	createNewProject($_POST["pagetitel"], $_POST["link"]);
	$notice = true;
}else{
	$notice = false;
}

?>
<head>
	<meta charset="utf-8">
	<meta name="description" content="HTML - Checker">
	<meta name="keywords" content="html">
	<link rel="stylesheet" href="default.css">
	<title>HTML - Checker</title>
</head>
<html>
<body>
<div class="container">
	<h1>HTML - Checker</h1>
	<h2>Create New Project to Check</h2>
	<form method="post" action="index.php">
		<div>
			<label>Page Titel: </label><br><input type="text" name="pagetitel" required>
		</div>
		<div>
			<label>Page Link: </label><br><input type="text" name="link" required>
		</div>
		<div>
			<input class="button" type="submit" value="Submit">
		</div>
	</form>
	<?php if ($notice) { ?>
		<div class="notice">
			<h3>Projekt wurde erfolgreich hinzugefügt! ^_^</h3>
		</div>
	<?php } ?>
	<h2>Last Changes:</h2>
	<table class="big-box">
		<tbody>
		<tr>
			<th>Titel</th>
			<th>Zeitpunkt der letzten Änderung</th>
			<th>Inhaltliche Änderungen im Vergleich zur aktuellen Seite</th>
			<th>Link</th>
		</tr>
		<?php for ($i = 0; $i < count($page); $i++) { ?>
			<tr>
				<?php
				echo "<td>" . $page[$i]["titel"] . "</td>";
				echo "<td>" . $page[$i]["date_old"] . "</td>";
				if(empty($page[$i]["content_changed"])){
					$page[$i]["content_changed"] = "Seit dem letzten Check gab es keine Änderungen";
				}
				echo "<td>" . $page[$i]["content_changed"] . "</td>";
				echo "<td><a href='" . $page[$i]["link"] . "'>" . $page[$i]["link"] . "</a></td>";
				?>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
</body>
</html>
