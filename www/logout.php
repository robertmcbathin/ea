<?include_once 'inc/header.php';
if (isset($_SESSION['user']))
{destroySession();
  echo "<div class='alertalert-info'><p align=center>Вы вышли из системы.</p>
  <p align=center><a class='post_href' href='index'>Кликните здесь</a> для перехода на главную страницу.</p></div>";
}
else echo "<div class='alert alert-warning'><p align=center>Вы не авторизованы в системе</p></div>";
include_once 'inc/footer.php';
?>
