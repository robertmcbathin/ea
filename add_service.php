<?
include_once 'inc/header.php';
$fio = $date_of_birth = $sex = $phone = $email = $passport_serie = $passport_number = $passport_date_of_issue = $passport_place_of_issue
 = $place_of_residence = $place_of_work = $profession = $dms = $dms_number = $valid = $comment = '';
/*Добавление пациента в картотеку*/
if(isset($_POST['fio']))
{
  $fio                     = $_POST['fio'];   
  $date_of_birth           = $_POST['date_of_birth'];
  $sex                     = $_POST['sex'];
  $phone                   = $_POST['phone'];
  $email                   = $_POST['email'];
  $place_of_residence      = $_POST['place_of_residence'];
  $place_of_work           = $_POST['place_of_work'];
  $profession              = $_POST['profession'];
  $passport_serie          = $_POST['passport_serie'];
  $passport_number         = $_POST['passport_number'];
  $passport_date_of_issue  = $_POST['passport_date_of_issue'];
  $passport_place_of_issue = $_POST['passport_place_of_issue'];
  $dms                     = $_POST['dms'];
  $dms_number              = $_POST['dms_number'];
  $valid                   = $_POST['valid'];
  $comment                 = $_POST['comment'];

$add_pacient_query = mysql_query("INSERT INTO `pacient` VALUES(null,'$fio','$date_of_birth',
  '$phone','$email','$sex','$passport_serie','$passport_number','$passport_date_of_issue',
  '$passport_place_of_issue', '$place_of_residence','$place_of_work','$profession','$dms',
  '$dms_number','$valid','$comment')");
//$lid_query = mysql_query("SELECT LAST_INSERT_ID() FROM `pacient`");
$last_id_request = mysql_query("SELECT LAST_INSERT_ID()");  
$last_id = mysql_result($last_id_request, 0);
$encoding_string = $fio . ' (' . $last_id . ')';
$encoded_fio = iconv("UTF-8","Windows-1251", $encoding_string);
$agreements = iconv("UTF-8","Windows-1251", "договоры");
$acts = iconv("UTF-8","Windows-1251", "акты");
$conclusions = iconv("UTF-8","Windows-1251", "заключения");
mkdir("docs/$encoded_fio");
mkdir("docs/$encoded_fio/$agreements");
mkdir("docs/$encoded_fio/$acts");
mkdir("docs/$encoded_fio/$conclusions");
if($add_pacient_query) die("<div class='container'>
<div class='alert alert-success'>
  <p align='center'>
    Запись добавлена. Можете перейти в
    <a href='card-index'>картотеку</a>
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
<form class="navbar-form navbar-left" method="post" action="add_pacient">
  <div class="form-group">
    <input type="text" name="fio" class="form-control" placeholder="ФИО" size="100" value="<?echo $fio;?>">
    <br>
    <br>
    <label for="passport_date_of_issue" class="h5">Дата рождения<br>
      <input type="date" name="date_of_birth" class="form-control" placeholder="Дата рождения" size="15" value="<?echo $date_of_birth;?>">
    </label>
    <br>
    <br>
    <input name="sex" type="text" class="form-control" placeholder="Пол" size="10" value="<?echo $sex;?>">
    <br>
    <br>
    <h4>КОНТАКТНАЯ ИНФОРМАЦИЯ</h4>
    <input name="phone" type="text" class="form-control" placeholder="Телефон" size="20" value="<?echo $phone;?>">
    <br>
    <br>
    <input name="email" type="email" class="form-control" placeholder="Электронная почта" size="70" value="<?echo $email;?>">
    <br>
    <br>
    <input name="place_of_residence" type="text" class="form-control" placeholder="Место жительства" size="50" value="<?echo $place_of_residence;?>">
    <br>
    <br>
    <input name="place_of_work" type="text" class="form-control" placeholder="Место работы" size="100" value="<?echo $place_of_work;?>">
    <br>
    <br>
    <input name="profession" type="text" class="form-control" placeholder="Должность" size="100" value="<?echo $profession;?>">
    <br>
    <br>
    <h4>ПАСПОРТНЫЕ ДАННЫЕ</h4>
    <input name="passport_serie" maxlength="4" type="text" class="form-control" placeholder="Серия" size="4" value="<?echo $passport_serie;?>">
    <input name="passport_number" maxlength="6" type="text" class="form-control" placeholder="Номер" size="6" value="<?echo $passport_number;?>"><br><br>
    <label for="passport_date_of_issue" class="h5">Дата выдачи<br>
      <input name="passport_date_of_issue" type="date" class="form-control" placeholder="Дата выдачи" size="10" value="<?echo $passport_date_of_issue;?>">
    </label><br><br>    
    <input name="passport_place_of_issue" type="text" class="form-control" placeholder="Кем выдан" size="70" value="<?echo $passport_place_of_issue;?>">
    <br>
    <br>
    <h4>ДМС</h4>
    <input name="dms" type="text" class="form-control" placeholder="ДМС (Страховая компания)" size="70" value="<?echo $dms;?>">
    <br>
    <br>
    <input name="dms_number" type="text" class="form-control" placeholder="Номер ДМС" size="20" value="<?echo $dms_number;?>">
    <br>
    <br>
    <input name="valid" type="text" class="form-control" placeholder="Действителен до:" size="20" value="<?echo $valid;?>">
    <br>
    <br>
    <textarea name="comment" class="form-control" placeholder="Дополнительная информация" cols="100" rows="5"><?echo $comment;?></textarea>
  </div>
  <br>
  <br>
  <button type="submit" class="btn btn-default">Добавить</button>
</form>
</div>
<?
include_once 'inc/footer.php';
?>