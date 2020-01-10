<?php
require_once ("db.php");
require_once ("class.Diff.php");
require_once ("notificator.php");

function get_part_of_string($start, $stop, $stop_option, $string, $incl_search_elements) {
    $extracted = "";
    $l_start = mb_strlen($start, "UTF-8");
    $l_stop = mb_strlen($stop, "UTF-8");
    
    // Leerzeichen voranstellen, um Probleme mit strpos() zu umgehen
    $string_tmp = " ".$string;
    // Startposition ermitteln
    $a_pos = strpos($string_tmp, $start);
    // Länge des gesamten Strings ermitteln
    $ls = mb_strlen($string_tmp, "UTF-8");
    
    // Falls nächstes Vorkommen von $stop nach $start gewünscht wird
    if ($stop_option == "next") {
        #echo "NEXT<BR>\n";
        // alle Zeichen VOR $a_pos aus dem String zu entfernen
        $string_tmp = substr($string_tmp, $a_pos+$l_start, $ls);
        // nächstens Vorkommen von $stop suchen
        $b_pos = strpos($string_tmp, $stop);
        // alle Zeichen NACH $b_pos aus dem String zu entfernen
        $string_tmp = substr($string_tmp, 0, $b_pos+1-$l_stop);
        #echo "string_tmp1: ".$string_tmp."<BR>\n";
    }
    // Falls letztes Vorkommen von $stop nach $start gewünscht wird
    elseif ($stop_option == "last") {
        echo "string_tmp: ".$string_tmp."<BR>\n";
        #echo "LAST<BR>\n";
        // alle Zeichen VOR $a_pos aus dem String zu entfernen
        $string_tmp = substr($string_tmp, $a_pos+$l_start, $ls);
        // letztes Vorkommen von $stop suchen
        $b_pos = strrpos($string_tmp, $stop);
        // alle Zeichen NACH $b_pos aus dem String zu entfernen
        $string_tmp = substr($string_tmp, 0, $b_pos+1-$l_stop);
        #echo "string_tmp1: ".$string_tmp."<BR>\n";
    }
    
    if ($incl_search_elements == 1) {
        $extracted = $start . $string_tmp . $stop;
    }
    else {
        $extracted = $string_tmp;
    }
    
    return $extracted;
}


$page = [];
if (!empty(intval(countProjects($pdo)["count"]))){
	$counter = intval(countProjects($pdo)["count"]);
} else {
	$counter = 0;
}

for ($i = 0; $i < $counter; $i++){
	$page[$i]["p_id"] = $i +1;
	$infoProject = getProjectData($pdo, $page[$i]["p_id"]);
	$infoUpdate = getData($pdo, $page[$i]["p_id"]);
	$page[$i]["titel"] = $infoProject["titel"];
	$page[$i]["link"] = $infoProject["link"];
	$page[$i]["email"] = $infoProject["email"];
	$page[$i]["content_new"] = file_get_contents($page[$i]["link"]);
	$page[$i]["content_new"] = str_replace("<div class = \"module module--stage stage loading\">","<!--SLIDER_START-->\n<div class = \"module module--stage stage loading\">", $page[$i]["content_new"]);
	$page[$i]["content_new"] = str_replace("<section class=\"module module--page-header\">","<!--SLIDER_STOP-->\n<section class=\"module module--page-header\">", $page[$i]["content_new"]);
	$page[$i]["content_new"] = get_part_of_string("<!--SLIDER_START-->", "<!--SLIDER_STOP-->", $stop_option = "next", $page[$i]["content_new"], $incl_search_elements = 1);
	$page[$i]["content_old"] = $infoUpdate["content"];
	$page[$i]["content_changed"] = "";
	$page[$i]["time_new"] = time();
	$page[$i]["time_old"] = $infoUpdate["timestamp"];
	$page[$i]["date_new"] = date("d.m.y H:i:s", $page[$i]["time_new"]);
	$page[$i]["date_old"] = date("d.m.y H:i:s", $page[$i]["time_old"]);
}