<?
$title = "Добавить врача";
include_once 'inc/header.php';
if(!$loggedin) exit;
$fio_full = $fio_short = $specialization = $phone = '';
/*Добавление пациента в картотеку*/
if(isset($_POST['fio_full']))
{
  $fio_full       = $_POST['fio_full'];   
  $fio_short      = $_POST['fio_short'];
  $specialization = $_POST['specialization'];
  $phone          = $_POST['phone'];

$add_doctor_query = mysql_query("INSERT INTO `doctor` VALUES(null,'$fio_full','$fio_short','$specialization','$phone')");
if($add_doctor_query) die("<div class='container'>
<div class='alert alert-success'>
  <p align='center'>
    Услуга добавлена. Можете перейти в
    <a href='settings'>меню настроек</a>
    .
  </p>
</div>
</div>
");
else die("
<div class='container'>
<div class='alert alert-danger'>
  <p align='center'>Что-то пошло не так.</p>
</div>
</div>
");
}
/*Конец добавления пациента в картотеку*/
?>
<div class="container">
<h3>ДОБАВЛЕНИЕ ВРАЧА</h3>
<form class="navbar-form navbar-left" method="post" action="add_doctor">
  <div class="form-group">
    <input type="text" name="fio_full" class="form-control" placeholder="Петров Пётр Петрович" size="100" maxlength="255" value="<?echo $fio_full;?>">
    <br>
    <br>
    <input type="text" name="fio_short" class="form-control" placeholder="Петров П.П." size="80" maxlength="80" value="<?echo $fio_short;?>">
    <br>
    <br>
    <input type="text" name="specialization" class="form-control" placeholder="Специализация" size="10" value="<?echo $specialization;?>">
    <br>
    <br>
    <input type="text" name="phone" class="form-control" placeholder="Контактный телефон" size="50" maxlength="80" value="<?echo $phone;?>">
  </div>
  <br>
  <br>
  <button type="submit" class="btn btn-default">Добавить</button>
</form>
</div>
<?
include_once 'inc/footer.php';
?>