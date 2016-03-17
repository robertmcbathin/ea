<?
$title = "Услуги: редактирование";
include_once '../sys/core/init.inc.php';
include_once 'inc/header.php';
if(!$loggedin) exit;
$cal = new Calendar($dbo);
if(isset($_POST['service_full_name']))
{
  $service_id         = $_POST['id'];
  $service_full_name  = $_POST['service_full_name'];
  $service_short_name = $_POST['service_short_name'];
  $price              = $_POST['price'];
  $referred_to        = $_POST['referred_to'];
  $change_service_query = ("UPDATE `service` SET `service_full_name`='$service_full_name',
                                                `service_short_name`='$service_short_name',
                                                `price` = '$price',
                                                `referred_to` = '$referred_to'
                           WHERE `service_id` = '$service_id'");
  if (mysql_query($change_service_query))
  {
    die("<div class='container'>
           <div class='alert alert-success'>
             <p align='center'>Запись изменена. Можете перейти в <a href='settings'>меню настроек</a>.</p>
           </div>
         </div>");
  }
  else
  {
    die("<div class='container'>
         <div class='alert alert-danger'>
           <p align='center'>Что-то пошло не так. Попробуйте повторить попытку.</p>
         </div>
       </div>");
  }
}
if(isset($_GET['change_service_id']))
{
  $service_id = $_GET['change_service_id'];
  $stmt = $cal->_getService($service_id);
  $r = $stmt->fetch(PDO::FETCH_ASSOC);
  echo <<<FORM_MARKUP
  <div class="container">
  <h1>$r[service_full_name]</h1>
    <form action="change_service_data" method="post">
      <label for="service_id">ID<input type="text" class="form-control" size="4" maxlength="4" name="service_id" value="$service_id" disabled></label><br>
      <label for="service_full_name">Наименование полное<input type="text" class="form-control" size="80"  maxlength="255" name="service_full_name" value="$r[service_full_name]"></label><br>
      <label for="service_short_name">Наименование краткое<input type="text" class="form-control" size="80" maxlength="80" name="service_short_name" value="$r[service_short_name]"></label><br>
      <label for="price">Цена<input type="text" class="form-control" size="10" maxlength="10" name="price" value="$r[price]"></label><br>
      <input type="hidden" value="$service_id" name="id"><br>
      <label for="referred_to">Раздел<input type="text" class="form-control" size="40" name="referred_to" maxlength="80"  value="$r[referred_to]"></label><br>
      <button type="submit" class="btn btn-default">Изменить</button>
    </form><br>
    <form action="confirmdelete_service" method="POST">
        <p>
          <input type="submit" name="delete_service" class="btn btn-primary" value="Удалить услугу"/>
          <input type="hidden" name="service_id" value="$service_id">
        </p>
      </form>
  </div>
FORM_MARKUP;
} else
{};
include_once 'inc/footer.php';
?>