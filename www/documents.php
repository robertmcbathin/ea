<?
include_once 'inc/header.php';
if(!$loggedin) exit;
/*Изменение информации о клиенте*/
if(isset($_POST['fio']))
{
      $current_pacient_id          = $_GET['id']; /*ID текущего пользователя*/
      $new_pacient_id              = $_POST['pacient_id'];
      $new_fio                     = $_POST['fio'];
      $new_date_of_birth           = $_POST['date_of_birth'];
      $new_phone                   = $_POST['phone'];
      $new_email                   = $_POST['email'];
      $new_sex                     = $_POST['sex'];
      $new_passport_serie          = $_POST['passport_serie'];
      $new_passport_number         = $_POST['passport_number'];
      $new_passport_date_of_issue  = $_POST['passport_date_of_issue'];
      $new_passport_place_of_issue = $_POST['passport_place_of_issue'];
      $new_place_of_residence      = $_POST['place_of_residence'];
      $new_place_of_work           = $_POST['place_of_work'];
      $new_profession              = $_POST['profession'];
      $new_dms                     = $_POST['dms'];
      $new_dms_number              = $_POST['dms_number'];
      $new_valid                   = $_POST['valid'];
      $new_comment                 = $_POST['comment'];
      

$query = ("UPDATE `pacient` 
           SET             
             `fio`                     =  '$new_fio',                    
             `date_of_birth`           =  '$new_date_of_birth',          
             `phone`                   =  '$new_phone',                  
             `email`                   =  '$new_email',                  
             `sex`                     =  '$new_sex',                    
             `passport_serie`          =  '$new_passport_serie',         
             `passport_number`         =  '$new_passport_number',        
             `passport_date_of_issue`  =  '$new_passport_date_of_issue', 
             `passport_place_of_issue` =  '$new_passport_place_of_issue',
             `place_of_residence`      =  '$new_place_of_residence',     
             `place_of_work`           =  '$new_place_of_work',          
             `profession`              =  '$new_profession',             
             `dms`                     =  '$new_dms',                    
             `dms_number`              =  '$new_dms_number',             
             `valid`                   =  '$new_valid',                  
             `comment`                 =  '$new_comment'       
           WHERE          `pacient_id` = '$current_pacient_id'         
            ");
$change_pacient_info = mysql_query($query);

if($change_pacient_info) die("<div class='container'>
                                <div class='alert alert-success'>
                                  <p align='center'>Запись изменена. Можете перейти в <a href='card-index'>картотеку</a>.</p>
                                </div>
                              </div>");
}
/*Конец изменениям информации о клиенте. Хватит это терпеть!*/

/*Сбор данных о пациенте*/
if(isset($_GET['id']))
{
  $current_id = $_GET['id'];
  $current_id_data_query = mysql_query("SELECT * FROM pacient WHERE pacient_id='$current_id'");
  if($current_id_data_query)
  {
    while ($r = mysql_fetch_assoc($current_id_data_query))
    {
      $pacient_id              = $r['pacient_id'];
      $fio                     = $r['fio'];
      $date_of_birth           = $r['date_of_birth'];
      $phone                   = $r['phone'];
      $email                   = $r['email'];
      $sex                     = $r['sex'];
      $passport_serie          = $r['passport_serie'];
      $passport_number         = $r['passport_number'];
      $passport_date_of_issue  = $r['passport_date_of_issue'];
      $passport_place_of_issue = $r['passport_place_of_issue'];
      $place_of_residence      = $r['place_of_residence'];
      $place_of_work           = $r['place_of_work'];
      $profession              = $r['profession'];
      $dms                     = $r['dms'];
      $dms_number              = $r['dms_number'];
      $valid                   = $r['valid'];
      $comment                 = $r['comment'];
    }                  
  }
}
/*Конец сбора данных о пациенте*/
?>
<div class="container">
<h1>ДОКУМЕНТЫ</h1>
  <div class="col-sm-4">
    <div class="panel panel-default">
      <div class="panel-heading"><span class="glyphicon glyphicon-inbox"></span> ДОГОВОРЫ</div>
        <div class="panel-body">
        <a href="add_pacient" class="btn btn-primary">СОЗДАТЬ ДОГОВОР</a>
        </div>
     </div>
  </div>
  <div class="col-sm-4">
    <div class="panel panel-default">
      <div class="panel-heading"><span class="glyphicon glyphicon-file"></span> АКТЫ</div>
        <div class="panel-body">
        </div>
     </div>
  </div>
  <div class="col-sm-4">
    <div class="panel panel-default">
      <div class="panel-heading"><span class="glyphicon glyphicon-list-alt"></span> ЗАКЛЮЧЕНИЯ</div>
        <div class="panel-body">
          <div class="list-group">
          </div>
          <a href="add_pacient" class="btn btn-primary">СОЗДАТЬ ЗАКЛЮЧЕНИЕ</a><br>
        </div>
     </div>
  </div>
</div>
<?
include_once 'inc/footer.php';
?>