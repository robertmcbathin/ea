<?
include_once 'inc/header.php';
if(!$loggedin) exit;
?>
<!--<div class="container">
  <div class="col-sm-6">
    <h1><span class="glyphicon glyphicon-stats"></span> СТАТИСТИКА</h1>
  </div>
  <div class="col-sm-6">
    <h2>ПОСЕТИТЕЛИ</h2><p>[КОЛИЧЕСТВО][СПИСОК]</p>
    <h2>ЗАЯВКИ</h2><p>[КОЛИЧЕСТВО][СПИСОК]</p>
  </div>
</div>-->
<div class="container">
  <div class="col-sm-4">
  	<div class="panel panel-default">
      <div class="panel-heading"><span class="glyphicon glyphicon-user"></span> КАРТОТЕКА</div>
        <div class="panel-body">
        </div>
     </div>
  </div>
  <div class="col-sm-4">
    <div class="panel panel-default">
      <div class="panel-heading"><span class="glyphicon glyphicon-pushpin"></span> БЛИЖАЙШИЕ НАЗНАЧЕНИЯ</div>
        <div class="panel-body">
        </div>
     </div>
  </div>
  <div class="col-sm-4">
    <div class="panel panel-default">
      <div class="panel-heading"><span class="glyphicon glyphicon-envelope"></span> ЭЛЕКТРОННАЯ РЕГИСТРАТУРА</div>
        <div class="panel-body">
          <div class="list-group">
            <?
              $request_list_query = mysql_query("SELECT rid,fio,phone,date_of_receive,direction FROM `request` WHERE status = 'new' ORDER BY date_of_receive DESC");
              if(mysql_num_rows($request_list_query) > 0)
              {
                while($r = mysql_fetch_assoc($request_list_query))
                {
                  echo "<a href='#'' class='list-group-item active'>
                         <h4 class='list-group-item-heading'>Поступило:<br>$r[date_of_receive]</h4>
                         <p class='list-group-item-text'>Номер: $r[rid]</p>
                         <p class='list-group-item-text'>$r[fio]</p>
                         <p class='list-group-item-text'>$r[phone]</p>
                         <p class='list-group-item-text'>$r[direction]</p>
                        </a>";
                }
              }
            ?>
          </div>
        </div>
     </div>
  </div>
</div>
<?
include_once 'inc/footer.php';
?>