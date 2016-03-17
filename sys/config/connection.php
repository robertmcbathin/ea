<?php // rnfunctions.php
$dbhost  = 'localhost';    // Unlikely to require changing
$dbname  = 'endoadmin'; // Modify these...
$dbuser  = 'root';     // ...variables according
$dbpass  = '';     // ...to your installation

$server = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());
$db = @mysql_connect($dbhost, $dbuser, $dbpass);
if (!$db)  {
echo "<center>Сервер базы данных не доступен,сообщите администратору по e-mail: mercile55@yandex.ru</center>";
exit();
}
if (!@mysql_select_db($dbname, $db))  {
echo "<center>Сервер базы данных не доступен,сообщите администратору по e-mail: mercile55@yandex.ru</center>";
exit();
}
$query = mysql_query("SET NAMES 'utf8'");
?>
