<?php
include_once '../sys/core/init.inc.php';
$cal = new Calendar($dbo);
// no term passed - just exit early with no response
if (empty($_GET['name'])) exit ;
$name = $_GET["name"];
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

$price = $cal->_getPriceByName($name);
echo $price;
?>