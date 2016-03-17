<?
$title = "Добавить услугу";
include_once 'inc/header.php';
if(!$loggedin) exit;
$service_full_name = $service_short_name = $price = $referred_to = '';
/*Добавление пациента в картотеку*/
if(isset($_POST['service_full_name']))
{
  $service_full_name  = $_POST['service_full_name'];   
  $service_short_name = $_POST['service_short_name'];
  $price              = $_POST['price'];
  $referred_to        = $_POST['referred_to'];

$add_service_query = mysql_query("INSERT INTO `service` VALUES(null,'$service_full_name','$service_short_name','$price','$referred_to')");
if($add_service_query) die("<div class='container'>
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
<h3>ДОБАВЛЕНИЕ УСЛУГИ</h3>
<form class="navbar-form navbar-left" method="post" action="add_service">
  <div class="form-group">
    <input type="text" name="service_full_name" class="form-control" placeholder="Полное наименование услуги" size="100" maxlength="255" value="<?echo $service_full_name;?>">
    <br>
    <br>
    <input type="text" name="service_short_name" class="form-control" placeholder="Краткое наименование услуги" size="80" maxlength="80" value="<?echo $service_short_name;?>">
    <br>
    <br>
    <input type="text" name="price" class="form-control" placeholder="Цена" size="10" value="<?echo $price;?>">
    <br>
    <br>
    <input type="text" name="referred_to" class="form-control" placeholder="Раздел" size="50" maxlength="80" value="<?echo $referred_to;?>">
  </div>
  <br>
  <br>
  <button type="submit" class="btn btn-default">Добавить</button>
</form>
</div>
<?
include_once 'inc/footer.php';
?>