<?php

$pdo = new PDO('mysql:host=localhost; dbname=stephan_projekt', 'root', NULL);

function updateContent($p_id, $content, $c_content, $time){
	GLOBAL $pdo;
	$statement = $pdo->prepare("INSERT INTO updates (p_id, content, changed_content, timestamp) VALUES (?, ?, ?, ?)");
	$statement->execute([$p_id, $content,$c_content, $time]);
}

function getData($p_id){
	GLOBAL $pdo;
	$statement = $pdo->prepare("SELECT * FROM updates WHERE timestamp = (SELECT MAX(timestamp) FROM updates) AND p_id = ?");
	$statement->execute([$p_id]);
	return $statement->fetch(PDO::FETCH_ASSOC);
}

function createNewProject($newProjectName, $websiteLink){
	GLOBAL $pdo;
	$statement = $pdo->prepare("INSERT INTO projects (beschreibung, link) VALUES (?, ?)");
	$statement->execute([$newProjectName, $websiteLink]);
}
//createNewProject("Google.com", "https://www.google.de/");