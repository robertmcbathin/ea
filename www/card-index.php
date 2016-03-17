<?
include_once 'inc/header.php';
if(!$loggedin) exit;
  $card_query = mysql_query("SELECT pacient_id,fio,date_of_birth,sex,phone FROM `pacient`");
  $num = 20;
  if(!isset($_GET['page']) or empty($_GET['page']) or $_GET['page']<1) $_GET['page'] = 1;
  $page = $_GET['page'];
  $posts = mysql_num_rows($card_query);
  $total = intval(($posts-1)/$num)+1;
  $page = intval($page);
  if($page > $total) $page = $total;
  $from = $page*$num-$num;
  $pervpage = "";
    $nextpage = "";
    $page2left = "";
    $page1left = "";
    $page2right = "";
    $page1right = "";
    if($page != 1) $pervpage = '<li><a href=?page=' . ($page-1) . ' aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
    if($page != $total) $nextpage = '<li><a href=?page=' . ($page + 1) . ' aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
    if($page - 2 > 0) $page2left = '<li><a class=nav_href href=?page='. ($page - 2) .'>'. ($page - 2) .'</a></li>';
    if($page - 1 > 0) $page1left = '<li><a class=nav_href href=?page='. ($page - 1) .'>'. ($page - 1) .'</a></li>';
    if($page + 2 <= $total) $page2right = '<li><a class=nav_href href=?page='. ($page + 2) .'>'. ($page + 2) .'</a></li>';
    if($page + 1 <= $total) $page1right = '<li><a class=nav_href href=?page='. ($page + 1) .'>'. ($page + 1) .'</a></li>';
    $currentpage = '<li class="active"><a class=nav_href href=#>'. $page . '</a></li>';
echo <<<_END
    <div class='container'>
    <div class="col-lg-8 col-sm-12">
      <nav>
        <ul class="pagination">
          $pervpage
          $page2left
          $page1left
          $currentpage
          $page1right
          $page2right
          $nextpage
        </ul>
      </nav>
    </div>
    <div class="col-lg-4 col-sm-12"><br>
      <div class='input-group'>
         <input type='text' size='20' maxlength='20' class='form-control right-float' id='search-patient' placeholder='Поиск пациента...'>
         <span class='input-group-btn'>
           <button class='btn btn-default' type='button'><span class='glyphicon glyphicon-search'></span></button>
         </span>
       </div>
    </div>
   </div>
_END;
   $card_query = mysql_query("SELECT pacient_id,fio,date_of_birth,comment,phone FROM `pacient` LIMIT $from,$num");
if($card_query)
{

  echo "<div class='container'>
  <div class='panel panel-default'>
  <!-- Default panel contents -->
    <div class='panel-heading'>ПАЦИЕНТЫ</div>
  <!-- Table -->
  <table class='table'>
    <thead>
      <tr>
        <th>#</th>  
            <th>ФИО</th>
            <th>Дата рождения</th>
            <th>Телефон</th>
            <th>Комментарий</th>
      </tr>
    </thead>
    <tbody>";
  while($r = mysql_fetch_assoc($card_query))
  {
    echo "<tr>
        <th>$r[pacient_id]</th>
        <td><a href='/pacient?id=$r[pacient_id]'>$r[fio]</a></td>
        <td>$r[date_of_birth]</td>
        <td>$r[phone]</td>
        <td>$r[comment]</td>
      </tr>";
  }
  echo "</tbody>
  </table>
  </div>"; //воткнуть paginator
  echo "</div>"; // конец .container

}

?>
<div class="container">
  <a href="add_pacient" class="btn btn-primary">ДОБАВИТЬ ПАЦИЕНТА</a><br>
</div>
<script src="js/patientListAjaxLoader.js"></script>
<?
include_once 'inc/footer.php';
?>