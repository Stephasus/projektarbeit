<?php
require_once  ("config.php");

if(!isset($update)&& !isset($sendeEmail)){
	$update = true;
	$sendeEmail = true;
}

for($i = 0; $i < count($page); $i++) {
	
	// create 2 dimensional array with content per line and that the line has changed or not
	$diff = Diff::compare($page[$i]["content_new"], $page[$i]["content_old"]);
	
	// creates a String with highlights on changed lines
	$output = Diff::toString($diff);

	$textarray = [];
	
	// splits highlighted string in array again
	foreach (preg_split("/((\r?\n)|(\r\n?))/", $output) as $line) {
		$textarray[] = $line;
	}
	$changedContent = "";
	$hasChanged = false;

	// loops through $diff array and whereever a line is changed it takes the content of the formated string and safes it in $changedContent as String
	for ($j = 0; $j < count($diff); $j++) {
		if ($diff[$j][1] == 1 || $diff[$j][1] == 2) {
			$hasChanged = true;
			$changedContent .= "Line " . $j . ": " . highlight_string($textarray[$j], true) . "<br/>";
			if ($diff[$j][1] == 2) {
				$changedContent .= "<br>";
			}
		}
	}
	$page[$i]["content_changed"] = $changedContent;

	
	if ($sendeEmail){
		sendeEmail($page[$i], "stephan.klusowski@gmail.com", "test");
	}

	// Content , Time and SiteLink are written in the Database
	if ($update && $hasChanged) {
		updateContent($page[$i]["p_id"], $page[$i]["content_new"], $page[$i]["content_changed"], $page[$i]["time_new"]);
	}
}

