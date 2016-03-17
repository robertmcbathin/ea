<?session_start();
include_once '../../sys/config/db-cred.inc.php';
foreach ($C as $name => $val) {
	define($name, $val);
}
$actions = array(
	          'app_edit' => array(
	          	       'object' => 'Calendar',
	          	       'method' => 'processForm',
	          	       'header' => 'Location: ../../'
	          	       )
	          );
if ($_POST['token']==$_SESSION['token'] && isset($actions[$_POST['action']]))
{
	$use_array = $actions[$_POST['action']];
	$obj = new $use_array['object']($dbo);
	if (TRUE === $msg=$obj->$use_array['method']())
	{
		header($use_array['header']);
		exit;
	}
	else
	{
		die($msg);
	}
}
else
{
	header("Location: ../../");
	exit;
}
function __autoload($class_name)
{
	$filename = '../../sys/class/class.' . strtolower($class_name) . '.inc.php';
	if(file_exists($filename))
	{
		include_once $filename;
	}
}
?>