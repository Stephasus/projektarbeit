<?php
require_once ("class.Diff.php");
require_once ("notificator.php");

$update = false;
$changesUpdate = false;

$pdo = new PDO('mysql:host=localhost; dbname=stephan_projekt', 'root', NULL);


$new_page = file_get_contents('https://www.example.com/');

$content = $new_page;
$time = time();
$website = "https://google.com";

$date = date("d.m.y", $time);

if($update){
	$statement = $pdo->prepare("INSERT INTO contents (content, date, website) VALUES (?, ?, ?)");
	$statement->execute([$content, $time, $website]);
}
// array('content' => $content, 'date' => $date, 'website' => $website)


$statement = $pdo->prepare("SELECT * FROM contents WHERE date = (SELECT MAX(date) FROM contents)");
$statement->execute();
$old_page = $statement->fetch(PDO::FETCH_ASSOC);

//$new_page = file_get_contents('https://www.example.com/');


$diff = Diff::compare($new_page, $old_page["content"]);
$output = Diff::toString($diff);
$textarray = [];

foreach(preg_split("/((\r?\n)|(\r\n?))/", $output) as $line){
    $textarray[] = $line;
}
$returnString = "";

for($i = 0; $i < count($diff); $i++){
	if($diff[$i][1] == 1 || $diff[$i][1] ==  2){
		$returnString .= "<span style='width: 75px; display: inline-block;'>Line " . $i . ": </span>" . highlight_string($textarray[$i], true) . "<br/>";
		if ($diff[$i][1] == 2){
			$returnString .= "<br>";
		}
	}
}
//echo $returnString;

if($changesUpdate){
	$statement = $pdo->prepare("INSERT INTO changes (c_content, date, website) VALUES (?, ?, ?)");
	$statement->execute([$returnString, $time, $website]);
}

$statement = $pdo->prepare("SELECT * FROM changes WHERE date = (SELECT MAX(date) FROM changes)");
$statement->execute();
$changes = $statement->fetch(PDO::FETCH_ASSOC);

$message = $changes["c_content"];

sendeEmail($message, "stephan.klusowski@gmail.com", "test");

//var_dump(highlight_string($output));


?>
