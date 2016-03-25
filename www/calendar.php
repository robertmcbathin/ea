<?
$page_title = "График приема";
include_once 'inc/header.php';
if(!$loggedin) exit;
?>
<div class="container calendar">
<?
$cal = new Calendar($dbo);
if(isset($_GET['day']))
{
	$current_date = $_GET['day'];
    $current_date_array= explode("-",$current_date);
   // echo $current_date_array[2];
    $current = $current_date_array[2];
	echo $cal->buildTimeline($current);
}else{
echo $cal->buildCalendar();
}
?>
</div>
<?
include_once 'inc/footer.php';
?>