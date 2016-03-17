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
  <?
    echo "<h3 class='head-name'><strong>#$pacient_id " . "$fio</strong></h3>";
  ?>
</div>
<div class="container">
  <div class="col-sm-6">
    <div class="panel panel-default">
      <div class="panel-heading">Персональные данные</div>
        <div class="panel-body">
          <form class="navbar-form navbar-left" method="post" action="pacient?id=<?echo $current_id;?>">
            <div class="form-group">
              <input name="pacient_id" type="text" class="form-control" placeholder="Номер" size="10" value="<?echo $pacient_id;?>" disabled><br><br>
              <input name="fio"type="text" class="form-control" placeholder="ФИО" size="40" value="<?echo $fio;?>"><br><br>
              <input name="date_of_birth" type="date" class="form-control" placeholder="Дата рождения" size="15" value="<?echo $date_of_birth;?>"><br><br>
              <input name="sex" type="text" class="form-control" placeholder="Пол" size="10" value="<?echo $sex;?>"><br><br>
              <h4>КОНТАКТНЫЕ ДАННЫЕ</h4>
              <input name="phone" type="text" class="form-control" placeholder="Телефон" size="20" value="<?echo $phone;?>"><br><br>
              <input name="email" type="email" class="form-control" placeholder="Электронная почта" size="40" value="<?echo $email;?>"><br><br>
              <input name="place_of_residence" type="text" class="form-control" placeholder="Место жительства" size="40" value="<?echo $place_of_residence;?>"><br><br>
              <input name="place_of_work" type="text" class="form-control" placeholder="Место работы" size="40" value="<?echo $place_of_work;?>"><br><br>
              <input name="profession" type="text" class="form-control" placeholder="Должность" size="40" value="<?echo $profession;?>"><br><br>
              <h4>ПАСПОРТНЫЕ ДАННЫЕ</h4>
              <input name="passport_serie" type="text" class="form-control" placeholder="Серия" size="4" value="<?echo $passport_serie;?>"><br><br>
              <input name="passport_number" type="text" class="form-control" placeholder="Номер" size="6" value="<?echo $passport_number;?>"><br><br>
              <input name="passport_date_of_issue" type="date" class="form-control" placeholder="Дата выдачи" size="10" value="<?echo $passport_date_of_issue;?>"><br><br>
              <input name="passport_place_of_issue" type="text" class="form-control" placeholder="Кем выдан" size="40" value="<?echo $passport_place_of_issue;?>"><br><br>
              <h4>ДАННЫЕ О ДОПОЛНИТЕЛЬНОМ МЕДИЦИНСКОМ СТРАХОВАНИИ</h4>
              <input name="dms" type="text" class="form-control" placeholder="ДМС (Страховая компания)" size="40" value="<?echo $dms;?>"><br><br>
              <input name="dms_number" type="text" class="form-control" placeholder="Номер ДМС" size="20" value="<?echo $dms_number;?>"><br><br>
              <input name="valid" type="date" class="form-control" placeholder="Действителен до:" size="20" value="<?echo $valid;?>"><br><br>
              <textarea name="comment" class="form-control" placeholder="Дополнительная информация" cols="35" rows="5"><?echo $comment;?></textarea>
            </div><br><br>
            <button type="submit" class="btn btn-default">Изменить</button>
          </form>
        </div>
    </div>
  </div>
  <div class="col-sm-6">
     <div class="panel panel-default">
      <div class="panel-heading">История посещений</div>
        <div class="panel-body">
        </div>
     </div>
     <div class="panel panel-default">
      <div class="panel-heading">Документы и файлы</div>
        <div class="panel-body">
      <!--  -->
        </div>
     </div>
  </div>
</div>
<?
include_once 'inc/footer.php';
?>