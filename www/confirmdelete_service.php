<?
if(isset($_POST['service_id']))
{
	$id = (int) $_POST['service_id'];
}
else
{
	header("Location: ./");
	exit;
}
include_once '../sys/core/init.inc.php';
$cal = new Calendar($dbo);
$markup = $cal->confirmDeleteService($id);
$page_title = "Удаление услуги";
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