<?
  if (isset($_GET['app_id']))
  {
  	$id = preg_replace('/[^0-9]/', '', $_GET['app_id']);
  	if(empty($id))
  	{
  		header("Location: ./");
  		exit;
  	}
  }
  else
  {
  	header("Location: ./");
    exit;
  }
  include_once '../sys/core/init.inc.php';
  include_once 'inc/header.php';
  if(!$loggedin) exit;
  $cal = new Calendar($dbo);
?>
<div id="content" class="container">
<?
  echo $cal->displayApp($id);
?>
<div class="col-sm-12"><a href="calendar" class="right-float">&laquo; Вернуться в календарь</a></div>
</div>
<?
include_once 'inc/footer.php';
?>