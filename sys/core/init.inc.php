<?session_start();
if(!isset($_SESSION['token']))
{
  $_SESSION['token'] = sha1(uniqid(mt_rand(),TRUE));
}
  include_once '../sys/config/connection.php';
  include_once '../sys/config/db-cred.inc.php';
  include_once '../sys/class/class.app.inc.php';
  include_once '../sys/class/class.db_connect.inc.php';
  include_once '../sys/class/class.calendar.inc.php';
  include_once '../sys/class/class.pacient_data_load.inc.php';
  foreach ($C as $name => $val) 
  {
  	define($name, $val);
  }
  $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
  $dbo = new PDO($dsn, DB_USER, DB_PASS);
?>