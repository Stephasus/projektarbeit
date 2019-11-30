<?php

function sendeEmail($message, $to = "stephan.kluowski@gmail.com", $subject = "test"){
	
	$lastChangeTime = $message["date_old"];
	$changes = $message["content_changed"];
	$projekt = $message["titel"];
	$link = $message["link"];
	
	$header  = "MIME-Version: 1.0\r\n";
	$header .= "Content-type: text/html; charset=utf-8\r\n";
	$header .= "From: toast@dings.com\r\n";
	$header .= "Reply-To: toast@dings.com\r\n";
	// $header .= "Cc: $cc\r\n";  // falls an CC gesendet werden soll
	$header .= "X-Mailer: PHP ". phpversion();
	
	$actualMessage = "Beim Projekt $projekt hat sich das HTML verändert.<br>";
	$actualMessage .= "Die letzte inhaltliche Änderung am Projekt fand am $lastChangeTime statt.<br><br>";
	$actualMessage .= "Hier eine Übersicht über die Änderungen:<br>";
	$actualMessage .= $changes . "<br><br>";
	$actualMessage .= "Link zur $projekt Seite: <a href='$link'>$link</a>";
	mail($to, $subject, $actualMessage, $header);
};
