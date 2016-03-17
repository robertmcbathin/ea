<?
$title = "Создать договор";
if (isset($_GET['app_id']))
{
  $id = preg_replace('/[^0-9]/', '', $_GET['app_id']);
  if(empty($id))
  {
    header("Location: ./");
    exit;
  }
}
else
{
  header("Location: ./");
  exit;
}
include_once '../sys/core/init.inc.php';
include_once 'inc/header.php';
if(!$loggedin) exit;
$cal = new Calendar($dbo);
$app = $cal->_loadAppById($id);
/*EMPTY FIELDS*/
$service_short_name2 = $price2 = $quantity2 = $sum2 = $doctor2 =
$service_short_name3 = $price3 = $quantity3 = $sum3 = $doctor3 =
$service_short_name4 = $price4 = $quantity4 = $sum4 = $doctor4 =
$service_short_name5 = $price5 = $quantity5 = $sum5 = $doctor5 = '';
$summary = '';
/*AUTOCOMPLETE FIELDS*/
$number = $app_id = $_GET['app_id'];
$pacient_name = $app->pacient_fio;
$passport_serie = $app->pacient_passport_serie;
$passport_number = $app->pacient_passport_number;
$passport_date_of_issue = $app->pacient_passport_date_of_issue;
$passport_place_of_issue = $app->pacient_passport_place_of_issue;
$place_of_residence = $app->pacient_place_of_residence;
$phone = $app->pacient_phone;
$main_service_short_name = $app->service_short_name;
$main_price = $app->price;
$main_quantity = 1;
$main_sum = $main_price*$main_quantity;
$doctor = $app->doctor_fio_full;
$period_from = date("Y-m-d");
$period_to = date("2016-12-31");
$current_date = date("d-m-y_H-i-s");
$current_day = date("d");
$current_month = $cal->_getMonthByNumber(date("m"));
$current_year = date("Y");
$summary = $main_sum;
/**
 * Create the agreement
 */
if (isset($_POST['number']))
{
  $number = $_POST['number'];
  $pacient_name = $_POST['pacient_name'];
  $passport_serie = $_POST['passport_serie'];
  $passport_number = $_POST['passport_number'];
  $passport_date_of_issue = $_POST['passport_date_of_issue'];
  $passport_place_of_issue = $_POST['passport_place_of_issue'];
  $place_of_residence = $_POST['place_of_residence'];
  $phone = $_POST['phone'];
  $period_from = date("Y-m-d");
  $period_to = $period_to = date("Y-m-d",strtotime($period_from) + 604800);
  /*CHANGING DATE OF ISSUE*/
  $issued_day = date("d",strtotime($passport_date_of_issue));
  $issued_month = date("m",strtotime($passport_date_of_issue));
  $issued_year = date("Y",strtotime($passport_date_of_issue));
  $issued_month_in_letters = $cal->_getMonthByNumber(date("m"));
  $passport_date_of_issue_in_letters = $issued_day . ' ' . $issued_month_in_letters . ' ' . $issued_year;
  /**/
  /**
   * Main service 
   */
  $main_service_short_name = $_POST['main_service_short_name'];
  $main_doctor = $_POST['main_doctor'];
  $main_price = $_POST['main_price'];
  $main_quantity = $_POST['main_quantity'];
  $main_sum = $cal->checkZero($main_price,$main_quantity);
  /*End of Main service*/
  /**
   * Additional services
   */
   $service_short_name2 = $_POST['service_short_name2'];
               $doctor2 =             $_POST['doctor2'];
                $price2 =             $_POST['price2'];
             $quantity2 =           $_POST['quantity2'];
                  $sum2 =         $cal->checkZero($price2,$quantity2);

   $service_short_name3 = $_POST['service_short_name3'];
               $doctor3 =             $_POST['doctor3'];
                $price3 =             $_POST['price3'];
             $quantity3 =           $_POST['quantity3'];
                  $sum3 =        $cal->checkZero($price3,$quantity4);

   $service_short_name4 = $_POST['service_short_name4'];
               $doctor4 =             $_POST['doctor4'];
                $price4 =             $_POST['price4'];
             $quantity4 =           $_POST['quantity4'];
                  $sum4 =        $cal->checkZero($price4,$quantity4);

   $service_short_name5 = $_POST['service_short_name5'];
               $doctor5 =             $_POST['doctor5'];
                $price5 =             $_POST['price5'];
             $quantity5 =           $_POST['quantity5'];
                  $sum5 =        $cal->checkZero($price5,$quantity5);
   /*End of additional services*/
   /**
    * [$summary Final summary]
    * @var [float]
    */
   $summary = $main_sum + $sum2 + $sum3 + $sum4 + $sum5;
   $sign_date = date("Y-m-d");
   $med_fio = $main_doctor;
   
/**
 * Get patient, doctor, service IDs
 */
  $pacient_id = $cal->_getID('pacient',$pacient_name);
  $service_id = $cal->_getID('service',$main_service_short_name);
  $doctor_id  = $cal->_getID('doctor',$main_doctor);

  $service2_id = $cal->_getID('service',$service_short_name2);
  $doctor2_id  = $cal->_getID('doctor',$doctor2);
  $service3_id = $cal->_getID('service',$service_short_name3);
  $doctor3_id  = $cal->_getID('doctor',$doctor3);
  $service3_id = $cal->_getID('service',$service_short_name4);
  $doctor3_id  = $cal->_getID('doctor',$doctor4);
  $service3_id = $cal->_getID('service',$service_short_name5);
  $doctor3_id  = $cal->_getID('doctor',$doctor5);
  /**
   * Get current prices
   */
  $main_price_id    = $cal->_getPrice($main_price);
  $price2_id        = $cal->_getPrice($price2);
  $price3_id        = $cal->_getPrice($price3);
  $price4_id        = $cal->_getPrice($price4);
  $price5_id        = $cal->_getPrice($price5);
  /*************************---------------------------WRITE TO THE DATABASE-----------------------***************************************************/
  $sql = "INSERT INTO `agreement_act_data` VALUES( '',
                                                   '$pacient_id',
                                                   '$app_id',
                                                   '$number',
                                                   '$period_from',
                                                   '$period_to',
                                                   '$service_id',
                                                   '$main_quantity',
                                                   '$doctor_id',
                                                   '$service2_id',
                                                   '$quantity2',
                                                   '$doctor2_id',
                                                   '$service3_id',
                                                   '$quantity3',
                                                   '$doctor3_id',
                                                   '$service4_id',
                                                   '$quantity4',
                                                   '$doctor4_id',
                                                   '$service5_id',
                                                   '$quantity5',
                                                   '$doctor5_id',
                                                   '$med_fio',
                                                   '$sign_date',
                                                   '$summary')";
  mysql_query($sql);
  /*************************---------------------------WRITTEN TO THE DATABASE-----------------------***************************************************/
  /*************************---------------------------WRITE TO DOCS-----------------------***************************************************/
  /**
   * INIT THE PHPWORD
   */
  require_once 'libraries/phpword/src/phpword/autoloader.php';
  require_once 'libraries/phpword/src/phpword/template.php';
  require_once 'libraries/phpword/src/phpword/iofactory.php';
  \phpoffice\phpword\autoloader::register();
  $phpWord = new \phpoffice\phpword\phpword();
  /**
   * SET DIRECTORY
   */
  $agreement_name = 'dogovor_' . $app->id . '_' . $pacient_id . '.docx';
  $act_name = 'akt_' . $app->id . '_' . $pacient_id . '.docx';
  $conclusion_name = 'zakluchenie_' . $app->id . '_' . $pacient_id . '.docx';
  $pacient_directory = 'docs/pacient/' . $pacient_id;
  $agreement_directory = $pacient_directory . '/' . 'agreements';
  $act_directory = $pacient_directory . '/' . 'acts';
  $conclusion_directory = $pacient_directory . '/' . 'conclusions';

  $agreement_directory_with_filename = $agreement_directory . '/' . $agreement_name;
  $act_directory_with_filename = $act_directory . '/' . $act_name;
  $conclusion_directory_with_filename = $conclusion_directory . '/' . $conclusion_name;
  /**
   * LOAD AGREEMENT TEMPLATE
   */
  $agreement_template = $phpWord->loadTemplate('templates/agreement_template2016.docx');
  /**
   * SET VALUES
   */
  $agreement_template->setValue('id', $number);
  $agreement_template->setValue('Date', $current_day);
  $agreement_template->setValue('Month', $current_month);
  $agreement_template->setValue('Year', $current_year);
  $agreement_template->setValue('pacient_name', $pacient_name);
  $agreement_template->setValue('current_slash_date',$period_from);
  $agreement_template->setValue('deadline',$period_to);
  $agreement_template->setValue('pacient_name2', $pacient_name);
  $agreement_template->setValue('phone', $phone);
  $agreement_template->setValue('passport_serie', $passport_serie);
  $agreement_template->setValue('passport_number', $passport_number);
  $agreement_template->setValue('passport_issued_date', $passport_date_of_issue_in_letters);
  $agreement_template->setValue('passport_place_of_issue', $passport_place_of_issue);
  $agreement_template->setValue('residential_address', $place_of_residence);
  /**
   * SAVING AGREEMENT
   */
  $agreement_template->saveAs($agreement_directory_with_filename);
  /**
   * LOAD ACT TEMPLATE
   */
  $act_template = $phpWord->loadTemplate('templates/act_template2016.docx');
  /**
   * SET VALUES
   */
  $act_current_date = date("d.m.y");
  $act_template->setValue('act_current_date',$act_current_date);
  $act_template->setValue('id',$number);
  $act_template->setValue('Date', $current_day);
  $act_template->setValue('Month', $current_month);
  $act_template->setValue('Year', $current_year);
  $act_template->setValue('doctor1',$main_doctor);
  $act_template->setValue('pacient_name',$pacient_name);
  $act_template->setValue('service1',$main_service_short_name);
  $act_template->setValue('q1',$main_quantity);
  $act_template->setValue('price1',$main_price);
  $act_template->setValue('summary1',$main_sum);
  $act_template->setValue('service2',$service_short_name2);
  $act_template->setValue('q2',$quantity2);
  $act_template->setValue('price2',$price2);
  $act_template->setValue('summary2',$sum2);
  $act_template->setValue('service3',$service_short_name3);
  $act_template->setValue('q3',$quantity3);
  $act_template->setValue('price3',$price3);
  $act_template->setValue('summary3',$sum3);
  $act_template->setValue('service4',$service_short_name4);
  $act_template->setValue('q4',$quantity4);
  $act_template->setValue('price4',$price4);
  $act_template->setValue('summary4',$sum4);
  $act_template->setValue('service5',$service_short_name5);
  $act_template->setValue('q5',$quantity5);
  $act_template->setValue('price5',$price5);
  $act_template->setValue('summary5',$sum5);
  $act_template->setValue('summary',$summary);

  $act_template->saveAs($act_directory_with_filename);

  /*ДОБАВИТЬ УСЛОВИЯ УСПЕШНОСТИ ВЫПОЛНЕНИЯ ВЫШЕПЕРЕЧИСЛЕННЫХ ДЕЙСТВИЙ*/
  die("<div class='container'>
         <div class='alert alert-success'>
           <p align='center'>
             Информация сохранена!
           </p>
           <a href='$agreement_directory_with_filename'><img src='pictures/wordicon.png'>Договор</a><br><br>
           <a href='$act_directory_with_filename'><img src='pictures/wordicon.png'>Акт</a>
         </div>
       </div>");
}
?>
<div id="content" class="container">
  <div class="col-sm-12">
    <h2>СОЗДАНИЕ ДОГОВОРА ПО НАЗНАЧЕНИЮ №<?echo $app->id;?></h2>
    <form action="create_agreement?app_id=<?echo $id;?>" class="navbar-form navbar-left" method="post">
      <div class="form-group">  
        <input type="text" class="form-control" id="agreement_number" maxlength="10" name="number" placeholder="Номер договора" size="12" value="<?php echo $number;?>"><br><br>
        <input type="text" class="form-control" maxlength="50" name="pacient_name" placeholder="ФИО пациента" size="50" value="<?php echo $pacient_name;?>">
        <h3>ПАСПОРТНЫЕ ДАННЫЕ</h3>
        <input type="text" class="form-control" maxlength="4" name="passport_serie" placeholder="Серия" size="5" value="<?php echo $passport_serie;?>">
        <input type="text" class="form-control" maxlength="6" name="passport_number" placeholder="Номер" size="5" value="<?php echo $passport_number;?>"><br><br>
        <input type="date" class="form-control" maxlength="10" name="passport_date_of_issue" placeholder="Дата выдачи" size="10" value="<?php echo $passport_date_of_issue;?>"><br><br>
        <input type="text" class="form-control" maxlength="100" name="passport_place_of_issue" placeholder="Кем выдан" size="100" value="<?php echo $passport_place_of_issue;?>">
        <h3>КОНТАКТНЫЕ ДАННЫЕ</h3>
        <input type="text" class="form-control" maxlength="100" name="place_of_residence" placeholder="Место фактического проживания" size="100" value="<?php echo $place_of_residence;?>"><br><br>
        <input type="text" class="form-control" maxlength="15" name="phone" placeholder="Номер телефона" size="20" value="<?php echo $phone;?>">
        <h3>ПЕРИОД ПРЕДОСТАВЛЕНИЯ УСЛУГ</h3>
        <label for="period_from">С:<input type="date" class="form-control" name="period_from" value="<?php echo $period_from;?>" disabled></label>
        <label for="period_to">по:<input type="date" class="form-control" name="period_to" value="<?php echo $period_to;?>"></label>
        <h3>ИНФОРМАЦИЯ ОБ УСЛУГАХ</h3>
        <h4>ОСНОВНАЯ УСЛУГА</h4>
        <table>
          <tr>
            <th>
              Услуга
            </th>
            <th>
              Врач
            </th>
            <th>
              Цена
            </th>
            <th>
              Кол-во
            </th>
            <th>
              Сумма
            </th>
          </tr>
          <tr>
            <td>
              <input type="text" class="form-control recalc" maxlength="40" id="main_service" name="main_service_short_name" placeholder="Наименование услуги" size="26" value="<?php echo $main_service_short_name;?>">
            </td>
            <td>
              <input type="text" class="form-control" maxlength="50" name="main_doctor" placeholder="Врач" size="29" value="<?php echo $doctor;?>">
            </td>
            <td>
              <input type="text" class="form-control recalc" maxlength="4" name="main_price" id="main_price" placeholder="Цена" size="4" value="<?php echo $main_price;?>">
            </td>
            <td>
              <input type="text" class="form-control recalc" maxlength="2" id="main_quantity" name="main_quantity" id="main_quantity" placeholder="Количество" size="2" value="<?php echo $main_quantity;?>">
            </td>
            <td>
              <input type="text" class="form-control" maxlength="6" name="sum" id="sum1" placeholder="Сумма" size="7" value="<?php echo $main_sum;?>">
            </td>
          </tr>
        </table>
        <script>
         $(function() {
           $(".service-list").autocomplete({
             source: "check_service.php",
             minLength: 1
           });
           $(".doctor-list").autocomplete({
             source: "check_doctor.php",
             minLength: 1
           });
         });
        </script>
        <h4>ДОПОЛНИТЕЛЬНЫЕ УСЛУГИ</h4>
        <div id="additional-services">
          <table id="additional-services">
          <!-- Дополнительная услуга (2) -->
          <tr>
            <td>
              <input type="text" class="form-control recalc service-list" id="service-list-2" maxlength="40" name="service_short_name2" placeholder="Наименование услуги" size="26" value="<?php echo $service_short_name2;?>">
            </td>
            <td>
              <input type="text" class="form-control doctor-list" maxlength="50" name="doctor2" placeholder="Врач" size="29" value="<?php echo $doctor2;?>">
            </td>
            <td>
              <input type="text" class="form-control recalc" id="price2" maxlength="4" name="price2" placeholder="Цена" size="4" value="<?php echo $price2;?>">
            </td>
            <td>
              <input type="text" class="form-control recalc" id="quantity2" maxlength="2" name="quantity2" placeholder="Количество" size="2" value="<?php echo $quantity2;?>">
            </td>
            <td>
              <input type="text" class="form-control" id="sum2" maxlength="6" name="sum2" placeholder="Сумма" size="7" value="<?php echo $sum2;?>">
            </td>
          </tr>
          <!-- Конец дополнительной услуги -->
          <!-- Дополнительная услуга (3) -->
          <tr>
            <td>
              <input type="text" class="form-control recalc service-list" maxlength="40" id="service-list-3" name="service_short_name3" placeholder="Наименование услуги" size="26" value="<?php echo $service_short_name3;?>">
            </td>
            <td>
              <input type="text" class="form-control doctor-list" maxlength="50" name="doctor3" placeholder="Врач" size="29" value="<?php echo $doctor3;?>">
            </td>
            <td>
              <input type="text" class="form-control recalc" id="price3" maxlength="4" name="price3" placeholder="Цена" size="4" value="<?php echo $price3;?>">
            </td>
            <td>
              <input type="text" class="form-control recalc" maxlength="2" id="quantity3" name="quantity3" placeholder="Количество" size="2" value="<?php echo $quantity3;?>">
            </td>
            <td>
              <input type="text" class="form-control" maxlength="6" name="sum3" id="sum3" placeholder="Сумма" size="7" value="<?php echo $sum3;?>">
            </td>
          </tr>
          <!-- Конец дополнительной услуги -->
          <!-- Дополнительная услуга (4) -->
          <tr>
            <td>
              <input type="text" class="form-control recalc service-list" maxlength="40" id="service-list-4" name="service_short_name4" placeholder="Наименование услуги" size="26" value="<?php echo $service_short_name4;?>">
            </td>
            <td>
              <input type="text" class="form-control doctor-list" maxlength="50" name="doctor4" placeholder="Врач" size="29" value="<?php echo $doctor4;?>">
            </td>
            <td>
              <input type="text" class="form-control recalc" id="price4" maxlength="4" name="price4" placeholder="Цена" size="4" value="<?php echo $price4;?>">
            </td>
            <td>
              <input type="text" class="form-control recalc" maxlength="2" name="quantity4" id="quantity4" placeholder="Количество" size="2" value="<?php echo $quantity4;?>">
            </td>
            <td>
              <input type="text" class="form-control" maxlength="6" name="sum4" id="sum4" placeholder="Сумма" size="7" value="<?php echo $sum4;?>">
            </td>
          </tr>
          <!-- Конец дополнительной услуги -->
          <!-- Дополнительная услуга (5) -->
          <tr>
            <td>
              <input type="text" class="form-control recalc service-list" maxlength="40" id="service-list-5" name="service_short_name5" placeholder="Наименование услуги" size="26" value="<?php echo $service_short_name5;?>">
            </td>
            <td>
              <input type="text" class="form-control doctor-list" maxlength="50" name="doctor5" placeholder="Врач" size="29" value="<?php echo $doctor5;?>">
            </td>
            <td>
              <input type="text" class="form-control recalc" id="price5" maxlength="4" name="price5" placeholder="Цена" size="4" value="<?php echo $price5;?>">
            </td>
            <td>
              <input type="text" class="form-control recalc" maxlength="2" name="quantity5" id="quantity5" placeholder="Количество" size="2" value="<?php echo $quantity5;?>">
            </td>
            <td>
              <input type="text" class="form-control" maxlength="6" name="sum5" id="sum5" placeholder="Сумма" size="7" value="<?php echo $sum5;?>">
            </td>
          </tr>
          <!-- Конец дополнительной услуги -->
          </table>
        </div>
        <br>
        <button class="btn btn-primary right-float" id="add-service"><span class="glyphicon glyphicon-plus"></span>ДОБАВИТЬ</button>
        <br><br>
        <label for="summary" class="right-float">Итого:<input type="text" id="summary" class="form-control right-float" maxlength="7" name="summary" size="6" value="<?php echo $summary;?>"></label>
      </div>   
      <input type="submit" class="btn btn-primary" id="submit_agreement"  value="Создать" name="submit-service">
    </form>
  </div>
  <div class="col-sm-12">
    <a href="/view?app_id=<? echo $id;?>" class="right-float">&laquo; Вернуться к назначению</a>
  </div>
</div>
<script>
  $(document).ready(function(){
    $('#additional-services').hide();
    $('#main_quantity').keyup(function(){
      var sum1 = $('#main_price').val() * $('#main_quantity').val();
      $('#sum1').val(sum1);
    });
    $('#quantity2').keyup(function(){
      var sum2 = $('#price2').val() * $('#quantity2').val();
      $('#sum2').val(sum2);
    });
    $('#quantity3').keyup(function(){
      var sum3 = $('#price3').val() * $('#quantity3').val();
      $('#sum3').val(sum3);
    });
    $('#quantity4').keyup(function(){
      var sum4 = $('#price4').val() * $('#quantity4').val();
      $('#sum4').val(sum4);
    });
    $('#quantity5').keyup(function(){
      var sum5 = $('#price5').val() * $('#quantity5').val();
      $('#sum5').val(sum5);
    });
    $('#service-list-2').blur(function(){
      var currentValue = $('#service-list-2').val();
      var request = 'name=' + currentValue;
      $.ajax({
        type: 'GET',
        url: 'get_price.php',
        data: request,
        success: function(data){
          $('#price2').val(data);
        }
      });
    }); // END OF AJAX
    $('#service-list-3').blur(function(){
      var currentValue = $('#service-list-3').val();
      var request = 'name=' + currentValue;
      $.ajax({
        type: 'GET',
        url: 'get_price.php',
        data: request,
        success: function(data){
          $('#price3').val(data);
        }
      });
    }); // END OF AJAX
    $('#service-list-4').blur(function(){
      var currentValue = $('#service-list-4').val();
      var request = 'name=' + currentValue;
      $.ajax({
        type: 'GET',
        url: 'get_price.php',
        data: request,
        success: function(data){
          $('#price4').val(data);
        }
      });
    }); // END OF AJAX
    $('#service-list-5').blur(function(){
      var currentValue = $('#service-list-5').val();
      var request = 'name=' + currentValue;
      $.ajax({
        type: 'GET',
        url: 'get_price.php',
        data: request,
        success: function(data){
          $('#price5').val(data);
        }
      });
    }); // END OF AJAX
    $('.recalc').blur(function(){
      var sum1 = +$('#sum1').val();
      var sum2 = +$('#sum2').val();
      var sum3 = +$('#sum3').val();
      var sum4 = +$('#sum4').val();
      var sum5 = +$('#sum5').val();
      var summary = sum1 + sum2 + sum3 + sum4 + sum5;
      $('#summary').val(summary);
    });
    $('.recalc').keyup(function(){
      var sum1 = +$('#sum1').val();
      var sum2 = +$('#sum2').val();
      var sum3 = +$('#sum3').val();
      var sum4 = +$('#sum4').val();
      var sum5 = +$('#sum5').val();
      var summary = sum1 + sum2 + sum3 + sum4+ sum5;
      $('#summary').val(summary);
    });
  });//END OF DOCUMENT.READY
  $('#add-service').click(function(){
    $('#additional-services').show(200);
    return false;
  });
</script>
<?
include_once 'inc/footer.php';
?>