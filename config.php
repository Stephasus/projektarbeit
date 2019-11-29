<?php
require_once ("class.Diff.php");
require_once ("notificator.php");
require_once ("db.php");

$page = [];

$i = 0;
// Page 1

$page[$i]["p_id"] = $i +1;
$page[$i]["content_new"] = file_get_contents('https://www.example.com/');
$page[$i]["content_old"] = getData($page[$i]["p_id"])["content"];
$page[$i]["content_changed"] = "";
$page[$i]["website"] = "https://www.example.com/";
$page[$i]["time"] = time();
$page[$i]["date"] = date("d.m.y", $page[$i]["time"]);
$i++;

// Page 2