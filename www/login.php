<?
  include_once 'inc/header.php';
  $error = $user = $psw = '';
  if(isset($_POST['user']))
  {
    $user = $_POST['user'];
    $psw  = $_POST['psw'];
    $salt = 'e23j093';
    $pre_encrypted_psw = "$salt" . "$psw" . "$user";
    $encrypted_psw = md5($pre_encrypted_psw);
    if ($user == "" || $psw == "")
    {
      $error = "Заполнены не все поля!";
    } 
    else
    {
      $query = "SELECT login,psw FROM person
                WHERE login='$user' AND psw = '$encrypted_psw'";
      if(mysql_num_rows(queryMysql($query)) == 0)
      {
        $error = "<div class='alert alert-danger'>Логин или пароль недействительны!</div>";
      }
      else
      {
        $_SESSION['user'] = $user;
        $_SESSION['psw']  = $encrypted_psw;
        $userSes          = $_SESSION['user'];
        $error = "OK!";
        die("<div class='container'><div class='alert alert-success'><p align='center'>Вы вошли под логином <strong>$_SESSION[user]</strong>.<br> Теперь Вы можете воспользоваться функциями системы.</p></div></div>");
      }
    }
  }
?>
  <div class="container">
    <div class="col-md-4 col-md-offset-3">
      <form class="form-signin" method="post" action="login"><?echo $error;?>
        <h2 class="form-signin-heading">Войдите в систему</h2>
        <label for="inputLogin" class="sr-only">Логин</label>
        <input type="text" name="user" id="inputLogin" class="form-control" placeholder="Логин" value="<?echo $user;?>" required autofocus size="50">
        <label for="inputPassword" class="sr-only">Пароль</label>
        <input type="password" name="psw" id="inputPassword" class="form-control" placeholder="Пароль" value="<?echo $psw;?>" required size="50">
        <div class="checkbox">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">ВОЙТИ</button>
      </form>
    </div>
  </div> <!-- /container -->
<?
include_once 'inc/footer.php';
?>
