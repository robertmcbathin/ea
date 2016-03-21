<?
$title = "Добавить пользователя";
include_once 'inc/header.php';
if(!$loggedin) exit;
$name = $name_short = $type = $specialization = $login = $email = $psw = '';
/*ДОБАВЛЕНИЕ ПОЛЬЗОВАТЕЛЯ*/
if(isset($_POST['name']))
{
  $name           = $_POST['name'];   
  $name_short     = $_POST['name_short'];
  $type           = $_POST['type'];  
  $specialization = $_POST['specialization'];
  $login          = $_POST['login'];  
  $email          = $_POST['email'];
  $psw          = $_POST['psw'];
  /*ХЭШИРОВАНИЕ ПАРОЛЯ*/
  $salt = 'e23j093';
  $pre_encrypted_psw = "$salt" . "$psw" . "$name";
  $encrypted_psw = md5($pre_encrypted_psw);
  /*------------------*/
$add_user_query = mysql_query("INSERT INTO `person` VALUES(null,'$name','$name_short','$type','$specialization','$email','$login','$encrypted_psw')");
if($add_user_query) die("<div class='container'>
<div class='alert alert-success'>
  <p align='center'>
    Пользователь добавлен. Можете перейти в
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
<h3>ДОБАВЛЕНИЕ ПОЛЬЗОВАТЕЛЯ</h3>
<form class="navbar-form navbar-left" method="post" action="add_user">
  <div class="form-group">
    <input type="text" name="name" class="form-control" placeholder="Петров Пётр Петрович" size="100" maxlength="255" value="<?echo $name;?>">
    <br>
    <br>
    <input type="text" name="name_short" class="form-control" placeholder="Петров П.П." size="80" maxlength="80" value="<?echo $name_short;?>">
    <br>
    <br>
    <input list="type" name="type" class="form-control" placeholder="Выберите тип" value="<?echo $type;?>">
    <datalist id="type">
      <option value="doctor"></option>
      <option value="administrator"></option>
      <option value="headmaster"></option>
    </datalist>
    <br>
    <br>
    <input type="text" name="specialization" class="form-control" placeholder="Специализация" size="40" value="<?echo $specialization;?>">
    <br>
    <br>
    <input type="text" name="email" class="form-control" placeholder="E-mail" size="50" maxlength="80" value="<?echo $email;?>">
    <br>
    <br>
    <input type="text" name="login" class="form-control" placeholder="Логин" size="50" maxlength="80" value="<?echo $login;?>">
    <br>
    <br>
    <input type="text" name="psw" class="form-control" placeholder="Пароль" size="50" maxlength="80" value="<?echo $psw;?>">
  </div>
  <br>
  <br>
  <button type="submit" class="btn btn-default">Добавить</button>
</form>
</div>
<?
include_once 'inc/footer.php';
?>