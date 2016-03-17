<?
if(isset($_POST['doctor_id']))
{
	$id = (int) $_POST['doctor_id'];
}
else
{
	header("Location: ./");
	exit;
}
include_once '../sys/core/init.inc.php';
$cal = new Calendar($dbo);
$markup = $cal->confirmDeleteDoctor($id);
$page_title = "Удаление врача из списка";
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