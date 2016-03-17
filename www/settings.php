<?
include_once '../sys/core/init.inc.php';
$page_title = "Настройки";
$price_in_table = '';
include_once 'inc/header.php';
if(!$loggedin) exit;
$cal = new Calendar($dbo);
/*GET PRICELIST*/
$stmt = $cal->_getPriceList();
while ($r = $stmt->fetch(PDO::FETCH_ASSOC))
{
  $price_in_table .= '<tr>'
                  . '<td>'
                  . $r['service_id']
                  . '</td>'
                  . '<td>'
                  . "<a href=\"change_service_data?change_service_id=$r[service_id]\"> $r[service_full_name]</a>"
                  . '</td>'
                  . '<td>'
                  . $r['service_short_name']
                  . '</td>'
                  . '<td><strong>'
                  . $r['price']
                  . '</strong></td>'
                  . '<td>'
                  . $r['referred_to']
                  . '</td>'
                  . '</tr>';
}
$pricelist = $stmt->fetchAll();
$stmt->closeCursor();
/*GET DOCTORLIST*/
$stmt = $cal->_getDoctorList();
while ($r = $stmt->fetch(PDO::FETCH_ASSOC))
{
  $doctor_in_table .= '<tr>'
                  . '<td>'
                  . $r['doctor_id']
                  . '</td>'
                  . '<td>'
                  . "<a href=\"change_doctor_data?change_doctor_id=$r[doctor_id]\"> $r[fio_full]</a>"
                  . '</td>'
                  . '<td>'
                  . $r['fio_short']
                  . '</td>'
                  . '<td><strong>'
                  . $r['specialization']
                  . '</strong></td>'
                  . '<td>'
                  . $r['phone']
                  . '</td>'
                  . '</tr>';
}
$pricelist = $stmt->fetchAll();
$stmt->closeCursor();
echo <<<HEAD_MARKUP
<div class="container">
  <h1>НАСТРОЙКИ</h1>
  <h2>СПРАВОЧНИКИ</h2>
  <div class="row">
HEAD_MARKUP;
/*-------------------СПИСОК УСЛУГ-----------------------------------*/
 /*    $service_query = mysql_query("SELECT pacient_id,fio,date_of_birth,sex,phone FROM `pacient` LIMIT $from,$num");
     if($service_query)
     {*/
echo "<div class='container'>
       <div class='panel panel-default'>
       <!-- Default panel contents -->
         <div class='panel-heading'>УСЛУГИ
           <span id='service-toggle' class='glyphicon glyphicon-chevron-down right-float' data-toggle='tooltip' title='Раскрыть список'></span>
           <a href='add_service'><span id='service-add' class='glyphicon glyphicon-plus right-float' data-toggle='tooltip' title='Добавить услугу'></span></a>
         </div>
       <!-- Table -->
       <table class='table' id='service-list-table'>
         <thead>
           <tr>
             <th>#</th>  
             <th>Наименование полное</th>
             <th>Наименование краткое</th>
             <th>Стоимость</th>
             <th>Раздел</th>
           </tr>
         </thead>
         <tbody>";
         echo $price_in_table;
       echo "</tbody>
       </table>
       </div>"; //воткнуть paginator
       echo "</div>"; // конец .container
     
  //   }  
/*-------------------КОНЕЦ СПИСКА УСЛУГ-----------------------------------*/
/*-------------------СПИСОК ВРАЧЕЙ-----------------------------------*/
echo "<div class='container'>
       <div class='panel panel-default'>
       <!-- Default panel contents -->
         <div class='panel-heading'>ВРАЧИ
           <span id='doctor-toggle' class='glyphicon glyphicon-chevron-down right-float' data-toggle='tooltip' title='Раскрыть список'></span>
           <a href='add_doctor'><span id='doctor-add' class='glyphicon glyphicon-plus right-float' data-toggle='tooltip' title='Добавить врача'></span></a>
         </div>
       <!-- Table -->
       <table class='table' id='doctor-list-table'>
         <thead>
           <tr>
             <th>#</th>  
             <th>ФИО полное</th>
             <th>ФИО краткое</th> 
             <th>Специализация</th>
             <th>Контактный телефон</th>
           </tr>
         </thead>
         <tbody>";
         echo $doctor_in_table;
       echo "</tbody>
       </table>
       </div>"; //воткнуть paginator
       echo "</div>"; // конец .container
     
/*-------------------КОНЕЦ СПИСКА ВРАЧЕЙ-----------------------------------*/
 echo "</div>
</div>";
?>
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('#service-toggle').click(function(){
      $('#service-list-table').toggle();
       if ($('#service-toggle').hasClass('glyphicon-chevron-down')){
         $('#service-toggle').removeClass('glyphicon-chevron-down');
         $('#service-toggle').addClass('glyphicon-chevron-up');
       } else {
         $('#service-toggle').removeClass('glyphicon-chevron-up');
         $('#service-toggle').addClass('glyphicon-chevron-down');
       }
    });
    $('#doctor-toggle').click(function(){
      $('#doctor-list-table').toggle();
       if ($('#doctor-toggle').hasClass('glyphicon-chevron-down')){
         $('#doctor-toggle').removeClass('glyphicon-chevron-down');
         $('#doctor-toggle').addClass('glyphicon-chevron-up');
       } else {
         $('#doctor-toggle').removeClass('glyphicon-chevron-up');
         $('#doctor-toggle').addClass('glyphicon-chevron-down');
       }
    });
  });
</script>
<?
include_once 'inc/footer.php';
?>