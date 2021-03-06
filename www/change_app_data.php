<?
$title = "Назначения: редактирование";
include_once '../sys/core/init.inc.php';
include_once 'inc/header.php';
if(!$loggedin) exit;
$cal = new Calendar($dbo);
if(isset($_POST['app_pacient']))
{
  $app_id          = (int)$_POST['app_id'];
  $pacient_id      = $cal->_getID('pacient',$_POST['app_pacient']);
  $service_id      = $cal->_getID('service',$_POST['service_list']);
  $doctor_id       = $cal->_getID('doctor',$_POST['doctor_list']);
  $date            = $_POST['app_date_start'];
  $start           = $_POST['app_time_start'] . ':00';
  $end             = $_POST['app_time_end'] . ':00';

  $datetime_start = $date . 'T' . $start . ':00' . '+00:00';
  $datetime_end = $date . 'T' . $end . ':00' . '+00:00';
  $change_app_query = ("UPDATE `appointment` SET `pacient_id` = '$pacient_id',
                                                 `service_id` = '$service_id',
                                                 `doctor_id`  = '$doctor_id',
                                                 `app_start`  = '$datetime_start',
                                                 `app_end`    = '$datetime_end'
                           WHERE `app_id` = '$app_id'");
  if (mysql_query($change_app_query))
  {
    die("<div class='container'>
           <div class='alert alert-success'>
             <p align='center'>Запись изменена. Можете перейти в <a href='calendar'>календарь</a>.</p>
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
if(isset($_POST['app_id']))
{
  $app_id = $_POST['app_id'];
  $app = $cal->_loadAppById($app_id);
  $ts = strtotime($app->start);
  $date = date('Y-m-d',$ts);
  $start = date('H:i', $ts);
  $end = date('H:i',strtotime($app->end));
  $stmt = $cal->_getApp($app_id);
  $r = $stmt->fetch(PDO::FETCH_ASSOC);
  $pacient_name = $cal->_getNameById('pacient',$r['pacient_id']);
  $service_name = $cal->_getNameById('service',$r['service_id']);
  $doctor_name = $cal->_getNameById('doctor',$r['doctor_id']);
  echo <<<FORM_MARKUP
  <div class="container">
  <h1>Назначение №$r[app_id]</h1>
    <form action="change_app_data" method="post">
     <fieldset>
      <label for="pacient_list">Пациент</label>
      <div class="ui-widget">
        <input id="pacient_list" class="form-control" name="app_pacient" value="$pacient_name">
      </div>
      <label for="service_list">Услуга</label>
      <div class="ui-widget">
        <input class="form-control" id="service_list" name="service_list" value="$service_name">
      </div>
      <label for="service_list">Врач</label>
      <div class="ui-widget">
      <input  class="form-control" id="doctor_list" name="doctor_list" size="80" value="$doctor_name">
      </div>
      <label for="app_date_start">Дата</label> 
      <input type="date" class="form-control" value="$date" name="app_date_start"> 
      <label for="app_time_start">Начало:</label> 
      <input type="time" class="form-control" size="10" value="$start" name="app_time_start"> 
      <label for="app_time_end">Конец:</label> 
      <input type="time" class="form-control" value="$end" name="app_time_end"> 
      <label for="app_descrition">Описание</label><br/>
      <input type="hidden" name="app_id" value="$app_id"/>
      <input type="hidden" name="token" value="$_SESSION[token]"/>
      <input type="hidden" name="action" value="app_edit"/>
      <input type="submit" class="btn btn-primary" name="app_submit" value="Сохранить изменения"/>
      или <a href="calendar">Отменить</a>
    </fieldset>
      </form>
  </div>
FORM_MARKUP;
} else
{};
include_once 'inc/footer.php';
?>