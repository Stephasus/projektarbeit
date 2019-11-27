<?php
require_once ("class.Diff.php");

$update = false;

$pdo = new PDO('mysql:host=localhost; dbname=stephan_projekt', 'root', NULL);


$old_page = file_get_contents('https://www.example.com/');

$content = $old_page;
$time = time();
$website = "https://google.com";

$date = date("d.m.y", $time);

if($update){
	$statement = $pdo->prepare("INSERT INTO contents (content, date, website) VALUES (?, ?, ?)");
	$statement->execute([$content, $time, $website]);
}
// array('content' => $content, 'date' => $date, 'website' => $website)


$statement = $pdo->prepare("SELECT content FROM contents");
$statement->execute();
$new_page = $statement->fetchAll(PDO::FETCH_ASSOC);
$new_page = end($new_page);
//$new_page = file_get_contents('https://www.example.com/');


$diff = Diff::compare($old_page, $new_page["content"]);
$output = Diff::toString($diff);
$test = "test";




var_dump(highlight_string($output));