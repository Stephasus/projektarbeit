<?php
$update = false;
require_once("update.php");

if (isset($_POST["pagetitel"]) && isset($_POST["link"]) && isset($_POST["email"])) {
	createNewProject($pdo, $_POST["pagetitel"], $_POST["link"], $_POST["email"]);
	$notice = true;
	unset($_POST["pagetitel"], $_POST["link"], $_POST["email"]);
} else {
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
					<label>Page Titel: <br><input type="text" name="pagetitel" required></label>
				</div>
				<div>
					<label>Page Link: <br><input type="text" name="link" required></label>
				</div>
				<div>
					<label>E-Mail Mitarbeiter: <br><input type="text" name="email" required></label>
				</div>
				<div>
					<input class="button" type="submit" value="Submit">
				</div>
			</form>
			<?php if ($notice) { ?>
				<div class="notice">
					<h3>Projekt wurde erfolgreich hinzugefügt!</h3>
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
						if (empty($page[$i]["content_changed"])) {
							$page[$i]["content_changed"] = "Seit dem letzten Check gab es keine Änderungen";
						}
						echo "<td>" . $page[$i]["content_changed"] . "</td>";
//						echo "<td>" . highlight_string($page[$i]["content_new"], true) . "</td>";
						echo "<td><a target='_blank' href='" . $page[$i]["link"] . "'>" . $page[$i]["link"] . "</a></td>";
						?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</body>
</html>
