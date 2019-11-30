<?php

$pdo = new PDO('mysql:host=localhost; dbname=stephan_projekt', 'root', NULL);

function updateContent($p_id, $content, $c_content, $time){
	GLOBAL $pdo;
	$statement = $pdo->prepare("INSERT INTO updates (p_id, content, changed_content, timestamp) VALUES (?, ?, ?, ?)");
	$statement->execute([$p_id, $content,$c_content, $time]);
}

function getData($p_id){
	GLOBAL $pdo;
	$statement = $pdo->prepare(
	"	SELECT * 
				FROM updates 
				WHERE timestamp = (SELECT MAX(timestamp) FROM updates WHERE p_id = ?)");
	$statement->execute([$p_id]);
	return $statement->fetch(PDO::FETCH_ASSOC);
}

function getProjectData($p_id){
	GLOBAL $pdo;
	$statement = $pdo->prepare(
	"	SELECT * 
				FROM projects
				WHERE p_id = ?");
	$statement->execute([$p_id]);
	return $statement->fetch(PDO::FETCH_ASSOC);
}

function countProjects(){
	GLOBAL $pdo;
	$statement = $pdo->prepare(
	"SELECT count(p_id) AS count FROM projects");
	$statement->execute();
	return $statement->fetch(PDO::FETCH_ASSOC);
}

function createNewProject($newProjectName, $websiteLink){
	GLOBAL $pdo;
	$statement = $pdo->prepare("INSERT INTO projects (titel, link) VALUES (?, ?)");
	$statement->execute([$newProjectName, $websiteLink]);
}