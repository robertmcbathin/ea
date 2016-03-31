<?
include_once '../sys/core/init.inc.php';
$page_title = "Добавление/редактирование назначения";
include_once 'inc/header.php';
if(!$loggedin) exit;
$cal = new Calendar($dbo);
//$pacient = new Pacient($dbo);
?>
<div class="container">
  <div class="content">
  	<?
        echo $cal->displayForm();
    //    $res = $cal->_loadPacientData();
  	?>
  </div>
</div>
<?
include_once 'inc/footer.php';
?>
