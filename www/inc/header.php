<?php
session_start();
include_once 'inc/connection.php';
include_once '../sys/core/init.inc.php';
if(isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
	$loggedin = TRUE;
}
else 
{
  $loggedin = FALSE;
}
if(!$loggedin)
{
echo <<<NOT_LOGIN
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>$page_title</title>
  <link rel="icon" type="image/png" href="/favicon.ico" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="css/icono.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
<!-- Optional theme -->
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/bootstrap-modify.css">
  <link rel="stylesheet" href="css/calendar.css">
  <link rel="stylesheet" href="css/sticky-footer.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <style type="text/css">
  .ui-autocomplete-loading {
    background: white url("pictures/loading.gif") right center no-repeat;
  }
  </style>
  <script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>
  <script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
</head>
<body>
    <header>    
      <div class="container">
        <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a href="index"><span class="glyphicon glyphicon-home"></span></a></li>
                <li><a href="calendar"><span class="glyphicon glyphicon-pencil"></span> ЗАПИСЬ <span class="badge">0</span></a></li>
                <li><a href="card-index"><span class="glyphicon glyphicon-user"></span> КАРТОТЕКА</a></li>
                <li><a href="documents"><span class="glyphicon glyphicon-folder-open"></span> ДОКУМЕНТЫ</a></li>
                <li><a href="settings"><span class="glyphicon glyphicon-cog"></span> НАСТРОЙКИ</a></li>
                <li><a href="faq"><span class="glyphicon glyphicon-question-sign"></span> СПРАВКА</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href='login'><span class='glyphicon glyphicon-log-in'></span> ВОЙТИ</a></li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
      </div>
    </header>
   <div class="container">
    <div class="col-md-3 col-md-offset-3">
      <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Ошибка:</span>
        Доступ запрещен
      </div>
    </div>
  </div> <!-- /container -->
NOT_LOGIN;
include_once 'inc/footer.php';
}
else
{
echo <<<LOGIN
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>$page_title</title>
  <link rel="icon" type="image/png" href="/favicon.ico" />
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="css/icono.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
<!-- Optional theme -->
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/bootstrap-modify.css">
  <link rel="stylesheet" href="css/calendar.css">
  <link rel="stylesheet" href="css/sticky-footer.css">
  <style type="text/css">
  .ui-autocomplete-loading {
    background: white url("pictures/loading.gif") right center no-repeat;
  }
  </style>
  <script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>
  <script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script>
  $(function() {
    $("#pacient_list").autocomplete({
      source: "check_pacient.php",
      minLength: 1
    });
    $("#service_list").autocomplete({
      source: "check_service.php",
      minLength: 1
    });
    $("#doctor_list").autocomplete({
      source: "check_doctor.php",
      minLength: 1
    });
  });
  </script>
</head>
<body>
    <header>    
      <div class="container">
        <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a href="index"><span class="glyphicon glyphicon-home"></span></a></li>
                 <li><a href="calendar"><span class="glyphicon glyphicon-pencil"></span> ЗАПИСЬ <span class="badge">0</span></a></li>
                <li><a href="card-index"><span class="glyphicon glyphicon-user"></span> КАРТОТЕКА</a></li>
                <li><a href="documents"><span class="glyphicon glyphicon-folder-open"></span> ДОКУМЕНТЫ</a></li>
                <li><a href="settings"><span class="glyphicon glyphicon-cog"></span> НАСТРОЙКИ</a></li>
                <li><a href="faq"><span class="glyphicon glyphicon-question-sign"></span> СПРАВКА</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href='logout'><span data-toggle='tooltip' title='Выйти' data-placement='bottom'><strong>$user </strong></span><span class='glyphicon glyphicon-log-out'></span></a>
                </li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
      </div>
    </header>
LOGIN;
}
?>