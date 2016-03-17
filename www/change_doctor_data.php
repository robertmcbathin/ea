<?
$title = "Врачи: редактирование";
include_once '../sys/core/init.inc.php';
include_once 'inc/header.php';
if(!$loggedin) exit;
$cal = new Calendar($dbo);
if(isset($_POST['fio_full']))
{
  $doctor_id      = $_POST['id'];
  $fio_full       = $_POST['fio_full'];
  $fio_short      = $_POST['fio_short'];
  $specialization = $_POST['specialization'];
  $phone          = $_POST['phone'];
  $change_doctor_query = ("UPDATE `doctor` SET `fio_full`       ='$fio_full',
                                                `fio_short`      ='$fio_short',
                                                `specialization` = '$specialization',
                                                `phone`          = '$phone'
                           WHERE `doctor_id` = '$doctor_id'");
  if (mysql_query($change_doctor_query))
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
if(isset($_GET['change_doctor_id']))
{
  $doctor_id = $_GET['change_doctor_id'];
  $stmt = $cal->_getDoctor($doctor_id);
  $r = $stmt->fetch(PDO::FETCH_ASSOC);
  echo <<<FORM_MARKUP
  <div class="container">
  <h1>$r[fio_full]</h1>
    <form action="change_doctor_data" method="post">
      <label for="doctor_id">ID<input type="text" class="form-control" size="4" maxlength="4" name="doctor_id" value="$doctor_id" disabled></label><br>
      <label for="fio_full">ФИО полностью<input type="text" class="form-control" size="80"  maxlength="255" name="fio_full" value="$r[fio_full]"></label><br>
      <label for="fio_short">ФИО краткое<input type="text" class="form-control" size="80" maxlength="80" name="fio_short" value="$r[fio_short]"></label><br>
      <label for="specialization">Специализация<input type="text" class="form-control" size="80" maxlength="150" name="specialization" value="$r[specialization]"></label><br>
      <input type="hidden" value="$doctor_id" name="id"><br>
      <label for="phone">Контактный телефон<input type="text" class="form-control" size="40" name="phone" maxlength="80"  value="$r[phone]"></label><br>
      <button type="submit" class="btn btn-default">Изменить</button>
    </form><br>
    <form action="confirmdelete_doctor" method="POST">
        <p>
          <input type="submit" name="delete_doctor" class="btn btn-primary" value="Удалить"/>
          <input type="hidden" name="doctor_id" value="$doctor_id">
        </p>
      </form>
  </div>
FORM_MARKUP;
} else
{};
include_once 'inc/footer.php';
?>