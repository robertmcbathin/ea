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
function createTable($name, $query)
{
	if (tableExists($name))
	{
		echo "Table '$name' already exists<br />";
	}
	else
	{
		queryMysql("CREATE TABLE $name($query)");
		echo "Table '$name' created<br />";
	}
}

function tableExists($name)
{
	$result = queryMysql("SHOW TABLES LIKE '$name'");
	return mysql_num_rows($result);
}

function queryMysql($query)
{
	$result = mysql_query($query) or die(mysql_error());
	return $result;
}

function destroySession()
{
	$_SESSION=array();
	if (session_id() != "" || isset($_COOKIE[session_name()]))
	    setcookie(session_name(), '', time()-2592000, '/');
	session_destroy();
}

function sanitizeString($var)
{
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
	return mysql_real_escape_string($var);
}
?>
