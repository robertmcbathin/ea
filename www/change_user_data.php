<?
$title = "Пользователи: редактирование";
include_once '../sys/core/init.inc.php';
include_once 'inc/header.php';
if(!$loggedin) exit;
$cal = new Calendar($dbo);
if(isset($_POST['name']))
{
  $person_id      = $_POST['id'];
  $name           = $_POST['name'];
  $name_short     = $_POST['name_short'];
  $type           = $_POST['type'];
  $specialization = $_POST['specialization'];
  $email          = $_POST['email'];
  $login          = $_POST['login'];
  $psw            = $_POST['psw'];
  /*ХЭШИРОВАНИЕ ПАРОЛЯ*/
  $salt = 'e23j093';
  $pre_encrypted_psw = "$salt" . "$psw" . "$login";
  $encrypted_psw = md5($pre_encrypted_psw);
  /*------------------*/
  $change_user_query = ("UPDATE `person` SET    `name`      ='$name',
                                                `name_short`     ='$name_short',
                                                `type`           = '$type',
                                                `specialization` = '$specialization',
                                                `email`          = '$email',
                                                `login`          = '$login',
                                                `psw`            = '$encrypted_psw'
                           WHERE `person_id` = '$person_id'");
  if (mysql_query($change_user_query))
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
if(isset($_GET['change_user_id']))
{
  $person_id = $_GET['change_user_id'];
  $stmt = $cal->_getUser($person_id);
  $r = $stmt->fetch(PDO::FETCH_ASSOC);
  echo <<<FORM_MARKUP
  <div class="container">
  <h1>$r[name_full]</h1>
    <form action="change_user_data" method="post">
      <label for="person_id">ID<input type="text" class="form-control" size="4" maxlength="4" name="person_id" value="$person_id" disabled></label><br>
      <label for="name">ФИО полностью<input type="text" class="form-control" size="80"  maxlength="255" name="name" value="$r[name]"></label><br>
      <label for="name_short">ФИО краткое<input type="text" class="form-control" size="80" maxlength="80" name="name_short" value="$r[name_short]"></label><br>
       <label for="type">Тип<input type="text" class="form-control" size="80" maxlength="150" name="type" value="$r[type]"></label><br>
      <label for="specialization">Специализация<input type="text" class="form-control" size="80" maxlength="150" name="specialization" value="$r[specialization]"></label><br>
      <input type="hidden" value="$person_id" name="id"><br>
      <label for="email">E-mail<input type="text" class="form-control" size="20" name="email" maxlength="80"  value="$r[email]"></label><br>
      <label for="login">Логин<input type="text" class="form-control" size="40" name="login" maxlength="80"  value="$r[login]"></label><br>
      <label for="login">Пароль<input type="text" class="form-control" size="40" name="psw" maxlength="80"  value="$r[psw]"></label><br>
      <button type="submit" class="btn btn-default">Изменить</button>
    </form><br>
    <form action="confirmdelete_user" method="POST">
        <p>
          <input type="submit" name="delete_person" class="btn btn-primary" value="Удалить"/>
          <input type="hidden" name="person_id" value="$person_id">
        </p>
      </form>
  </div>
FORM_MARKUP;
} else
{};
include_once 'inc/footer.php';
?>