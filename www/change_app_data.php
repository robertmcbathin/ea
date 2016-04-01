<?
$title = "Назначения: редактирование";
include_once '../sys/core/init.inc.php';
include_once 'inc/header.php';
if(!$loggedin) exit;
$cal = new Calendar($dbo);
if(isset($_POST['app_id']))
{
//  $doctor_id      = $_POST['id'];
//  $fio_full       = $_POST['fio_full'];
//  $fio_short      = $_POST['fio_short'];
//  $specialization = $_POST['specialization'];
//  $phone          = $_POST['phone'];
//  $change_doctor_query = ("UPDATE `doctor` SET `fio_full`       ='$fio_full',
//                                                `fio_short`      ='$fio_short',
//                                                `specialization` = '$specialization',
//                                                `phone`          = '$phone'
//                           WHERE `doctor_id` = '$doctor_id'");
//  if (mysql_query($change_doctor_query))
//  {
//    die("<div class='container'>
//           <div class='alert alert-success'>
//             <p align='center'>Запись изменена. Можете перейти в <a href='settings'>меню //настроек</a>.</p>
//           </div>
//         </div>");
//  }
//  else
//  {
//    die("<div class='container'>
//         <div class='alert alert-danger'>
//           <p align='center'>Что-то пошло не так. Попробуйте повторить попытку.</p>
//         </div>
//       </div>");
//  }
}
if(isset($_POST['app_id']))
{
  $app_id = $_POST['app_id'];
  $app = $cal->_loadAppById($app_id);
  print_r($app);
  $ts = strtotime($app->start);
  $date = date('Y-m-d',$ts);
  $start = date('H:i', $ts);
  $end = date('H:i',strtotime($app->end));
  echo "<br>$date $start $end";
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
      <label for="app_descrition">Описание</label>
      <textarea name="app_descrition" cols="40" rows="10" class="form-control" id="app_descrition">
      $r[app_desc]</textarea><br/>
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