<?
if(isset($_POST['app_id']))
{
	$id = (int) $_POST['app_id'];
}
else
{
	header("Location: ./");
	exit;
}
include_once '../sys/core/init.inc.php';
$cal = new Calendar($dbo);
$markup = $cal->confirmDelete($id);
$page_title = "Удаление назначения";
include_once 'inc/header.php';
?>
<div class="container">
  <div class="content">
  	<?
  	echo $markup;
  	?>
  </div>
</div>
<?
include_once 'inc/footer.php';
?>