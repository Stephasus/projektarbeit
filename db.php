<?php

$pdo = new PDO('mysql:host=localhost; dbname=stephan_projekt', 'root', null);

function updateContent(PDO $pdo,$p_id, $content, $c_content, $time) {
	$statement = $pdo->prepare(
	"
					INSERT INTO updates 
					(p_id, content, changed_content, timestamp) 
					VALUES (?, ?, ?, ?)");
	$statement->execute([$p_id, $content, $c_content, $time]);
}

function getData(PDO $pdo, $p_id) {
	$statement = $pdo->prepare(
	"	SELECT * 
				FROM updates 
				WHERE timestamp = (SELECT MAX(timestamp) FROM updates WHERE p_id = ?)");
	$statement->execute([$p_id]);
	return $statement->fetch(PDO::FETCH_ASSOC);
}

function getProjectData(PDO $pdo, $p_id) {
	$statement = $pdo->prepare(
	"	SELECT * 
				FROM projects
				WHERE p_id = ?");
	$statement->execute([$p_id]);
	return $statement->fetch(PDO::FETCH_ASSOC);
}

function countProjects(PDO $pdo) {
	$statement = $pdo->prepare(
	"SELECT count(p_id) AS count FROM projects");
	$statement->execute();
	return $statement->fetch(PDO::FETCH_ASSOC);
}

function createNewProject(PDO $pdo, $newProjectName, $websiteLink, $email) {
	$statement = $pdo->prepare("INSERT INTO projects (titel,link,email) VALUES (?, ?, ?)");
	$statement->execute([$newProjectName, $websiteLink, $email]);
}