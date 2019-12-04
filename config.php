<?php
require_once ("class.Diff.php");
require_once ("notificator.php");
require_once ("db.php");

$page = [];
$counter = intval(countProjects($pdo)["count"]);

for ($i = 0; $i < $counter; $i++){
	$page[$i]["p_id"] = $i +1;
	$infoProject = getProjectData($pdo, $page[$i]["p_id"]);
	$infoUpdate = getData($pdo, $page[$i]["p_id"]);
	$page[$i]["titel"] = $infoProject["titel"];
	$page[$i]["link"] = $infoProject["link"];
	$page[$i]["email"] = $infoProject["email"];
	$page[$i]["content_new"] = file_get_contents($page[$i]["link"]);
	$page[$i]["content_old"] = $infoUpdate["content"];
	$page[$i]["content_changed"] = "";
	$page[$i]["time_new"] = time();
	$page[$i]["time_old"] = $infoUpdate["timestamp"];
	$page[$i]["date_new"] = date("d.m.y H:i:s", $page[$i]["time_new"]);
	$page[$i]["date_old"] = date("d.m.y H:i:s", $page[$i]["time_old"]);
}