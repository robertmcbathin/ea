<?php
include_once '../sys/core/init.inc.php';
$cal = new Calendar($dbo);
// no term passed - just exit early with no response
if (empty($_GET['term'])) exit ;
$q = strtolower($_GET["term"]);
//if (get_magic_quotes_gpc()) $q = stripslashes($q)
// remove slashes if they were magically added
/*$items = array(
"Борисов Михаил Иванович" =>"Борисов Михаил Иванович" ,
"Ефимова Ольга Петровна" => "Ефимова Ольга Петровна"
	);*/
/*$items = array(
"Борисов Михаил Иванович" =>"Борисов Михаил Иванович" ,
"Ефимова Ольга Петровна" => "Ефимова Ольга Петровна" 
);*/

$items = $cal->_loadServiceData();
/*$items = array(
"Борисов Михаил Иванович" =>"Борисов Михаил Иванович" ,
"Ефимова Ольга Петровна" => "Ефимова Ольга Петровна" 
);*/
//echo "<pre>";
//print_r($items);
//echo "</pre>";
$result = array();
foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		array_push($result, array("id"=>$value, "label"=>$key, "value" => strip_tags($key)));
	}
	if (count($result) > 11)
		break;
}
// json_encode is available in PHP 5.2 and above, or you can install a PECL module in earlier versions
echo json_encode($result);
?>