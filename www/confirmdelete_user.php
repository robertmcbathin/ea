<?
if(isset($_POST['person_id']))
{
	$id = (int) $_POST['person_id'];
}
else
{
	header("Location: ./");
	exit;
}
include_once '../sys/core/init.inc.php';
$cal = new Calendar($dbo);
$markup = $cal->confirmDeleteUser($id);
$page_title = "Удаление пользователя из списка";
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