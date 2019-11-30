<?php
require_once ("class.Diff.php");
require_once ("notificator.php");
require_once ("db.php");

$page = [];
$counter = intval(countProjects()["count"]);

for ($i = 0; $i < $counter; $i++){
	$page[$i]["p_id"] = $i +1;
	$page[$i]["titel"] = getProjectData($page[$i]["p_id"])["titel"];
	$page[$i]["link"] = getProjectData($page[$i]["p_id"])["link"];
	$page[$i]["content_new"] = file_get_contents($page[$i]["link"]);
	$page[$i]["content_old"] = getData($page[$i]["p_id"])["content"];
	$page[$i]["content_changed"] = "";
	$page[$i]["time_new"] = time();
	$page[$i]["time_old"] = getData($page[$i]["p_id"])["timestamp"];
	$page[$i]["date_new"] = date("d.m.y H:i:s", $page[$i]["time_new"]);
	$page[$i]["date_old"] = date("d.m.y H:i:s", $page[$i]["time_old"]);
}