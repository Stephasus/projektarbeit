<?php
$to = "stephan.klusowski@gmail.com";
$subject = "test";
$message = "";


function sendeEmail($message, $to = "stephan.kluowski@gmail.com", $subject = "test"){
	$head = $subject;
	$at = $to;
	$actualMessage = "Dies ist der Header für diese Email <br><br>";
	$actualMessage .= $message . "<br><br>";
	$actualMessage .= "dies ist das ende der email";
	mail($at, $head, $actualMessage);
};
