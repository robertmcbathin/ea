<?
include_once 'inc/header.php';
if(!$loggedin) exit;
?>
 <div class="container">
        <?php
       $id = $pacient_name = $passport_serie = $passport_number = $passport_issued_date = $residential_address = $service1 = $service2 = $service3 = $service4 = $service5 = $service6 =
         $q1 =  $q2 = $q3 = $q4 = $q5 = $q6 = $price1 = $price2 = $price3 = $price4 = $price5 = $price6 = $summary1 = $summary2 = $summary3 = $summary4 = $summary5 = 
         $summary6 = $ex_date1 = $ex_date2 = $ex_date3 = $ex_date4 = $ex_date5 = $ex_date6 = $doctor1 = $doctor2 = $doctor3 = $doctor4 = $doctor5 = $doctor6 = $phone = 
         $signed_person = '';
         
         if(isset($_POST['pacient_name'])){
          require_once 'libraries/phpword/src/phpword/autoloader.php';
          require_once 'libraries/phpword/src/phpword/template.php';
          require_once 'libraries/phpword/src/phpword/iofactory.php';
          \phpoffice\phpword\autoloader::register();
          $phpWord = new \phpoffice\phpword\phpword();

                           $id =                   $_POST['id'];
                 $pacient_name =         $_POST['pacient_name'];
               $passport_serie =       $_POST['passport_serie'];
              $passport_number =      $_POST['passport_number'];
         $passport_issued_date = $_POST['passport_issued_date'];
          $residential_address =  $_POST['residential_address'];
                      $phone   =                $_POST['phone'];
                      //Услуги
                      $service1 =              $_POST['service1'];
                            $q1 =                    $_POST['q1'];
                        $price1 =                $_POST['price1'];
                      $summary1 =              $q1 * $price1;
                      $ex_date1 =              date("d.m.y");
                       $doctor1 =               $_POST['doctor1'];
         
                      $service2 =              $_POST['service2'];
                            $q2 =                    $_POST['q2'];
                        $price2 =                $_POST['price2'];
                      $summary2 =              $q2 * $price2;
                      $ex_date2 =              date("d.m.y");
                       $doctor2 =               $_POST['doctor2'];

                      $service3 =              $_POST['service3'];
                            $q3 =                    $_POST['q3'];
                        $price3 =                $_POST['price3'];
                      $summary3 =              $q3 * $price3;
                      $ex_date3 =              date("d.m.y");
                       $doctor3 =               $_POST['doctor3'];

                      $service4 =              $_POST['service5'];
                            $q4 =                    $_POST['q5'];
                        $price4 =                $_POST['price5'];
                      $summary4 =              $q4 * $price4;
                      $ex_date4 =              date("d.m.y");
                       $doctor4 =               $_POST['doctor5'];

                      $service5 =              $_POST['service5'];
                            $q5 =                    $_POST['q5'];
                        $price5 =                $_POST['price5'];
                      $summary5 =              $q5 * $price5;
                      $ex_date5 =              date("d.m.y");
                       $doctor5 =               $_POST['doctor5'];

                      $service6 =              $_POST['service6'];
                            $q6 =                    $_POST['q6'];
                        $price6 =                $_POST['price6'];
                      $summary6 =              $q6 * $price6;
                      $ex_date6 =              date("d.m.y");
                       $doctor6 =               $_POST['doctor6'];
         //конец услуги
         $summary = $summary1 + $summary2 + $summary3 +$summary4+ $summary5 + $summary6;
         $signed_person = $_POST['signed_person'];
         $current_date = date("d-m-y_H-i-s");
         $current_day = date("d");
         $current_month = date("m");
         $current_year = date("y");
         $agreement_name = 'dogovor_' .  $current_date . '_' . $id . '.docx';
         $agreement_template = $phpWord->loadTemplate('agreement_template.docx');
         $agreement_template->setValue('id', $id);
         $agreement_template->setValue('Date', $current_day);
         $agreement_template->setValue('Month', $current_month);
         $agreement_template->setValue('Year', $current_year);
         $agreement_template->setValue('pacient_name', $pacient_name);
         $agreement_template->setValue('pacient_name2', $pacient_name);
         $agreement_template->setValue('phone', $phone);
         $agreement_template->setValue('passport_serie', $passport_serie);
         $agreement_template->setValue('passport_number', $passport_number);
         $agreement_template->setValue('passport_issued_date', $passport_issued_date);
         $agreement_template->setValue('residential_address', $residential_address);

         $agreement_template->setValue('service1', $service1);
         $agreement_template->setValue('q1', $q1);
         $agreement_template->setValue('price1', $price1);
         if($summary1 != ''){
          $agreement_template->setValue('summary1', $summary1);
        } else{
          $agreement_template->setValue('summary1', '');
          }
          if($service1 != ''){
          $agreement_template->setValue('ex_date1', $ex_date1);
        } else{
          $agreement_template->setValue('ex_date1', '');
          }
         $agreement_template->setValue('doctor1', $doctor1);

         $agreement_template->setValue('service2', $service2);
         $agreement_template->setValue('q2', $q2);
         $agreement_template->setValue('price2', $price2);
         if($summary2 != ''){
          $agreement_template->setValue('summary2', $summary2);
        } else{
          $agreement_template->setValue('summary2', '');
          }
          if($service2 != ''){
            $agreement_template->setValue('ex_date2', $ex_date2);
            } else{
          $agreement_template->setValue('ex_date2', '');
          }
         $agreement_template->setValue('doctor2', $doctor2);

         $agreement_template->setValue('service3', $service3);
         $agreement_template->setValue('q3', $q3);
         $agreement_template->setValue('price3', $price3);
         if($summary3 != ''){
          $agreement_template->setValue('summary3', $summary3);
        } else{
          $agreement_template->setValue('summary3', '');
          }
         if($service3 != ''){
            $agreement_template->setValue('ex_date3', $ex_date3);
            } else{
          $agreement_template->setValue('ex_date3', '');
          }
         $agreement_template->setValue('doctor3', $doctor3);

         $agreement_template->setValue('service4', $service4);
         $agreement_template->setValue('q4', $q4);
         $agreement_template->setValue('price4', $price4);
         if($summary4 != ''){
          $agreement_template->setValue('summary4', $summary4);
        } else{
          $agreement_template->setValue('summary4', '');
          }
         if($service4 != ''){
            $agreement_template->setValue('ex_date4', $ex_date4);
            } else{
          $agreement_template->setValue('ex_date4', '');
          }
         $agreement_template->setValue('doctor4', $doctor4);

         $agreement_template->setValue('service5', $service5);
         $agreement_template->setValue('q5', $q5);
         $agreement_template->setValue('price5', $price5);
         if($summary5 != ''){
          $agreement_template->setValue('summary5', $summary5);
        } else{
          $agreement_template->setValue('summary5', '');
          }
         if($service5 != ''){
            $agreement_template->setValue('ex_date5', $ex_date5);
            } else{
          $agreement_template->setValue('ex_date5', '');
          }
         $agreement_template->setValue('doctor5', $doctor5);

         $agreement_template->setValue('service6', $service6);
         $agreement_template->setValue('q6', $q6);
         $agreement_template->setValue('price6', $price6);
         if($summary6 != ''){
          $agreement_template->setValue('summary6', $summary6);
        } else{
          $agreement_template->setValue('summary6', '');
          }
         if($service6 != ''){
            $agreement_template->setValue('ex_date6', $ex_date6);
            } else{
          $agreement_template->setValue('ex_date6', '');
          }
         $agreement_template->setValue('doctor6', $doctor6);
         $agreement_template->setValue('summary', $summary);
         $agreement_template->setValue('signed_person', $signed_person);
    //     $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
      //   $objWriter->save('agreements/agreement_name3.docx');
         $agreement_directory = 'agreements/' . $agreement_name; 
         $agreement_template->saveAs($agreement_directory);

         $act_current_date = date("d.m.y");
         $act_template = $phpWord->loadTemplate('act_template.docx');
         $act_template->setValue('act_current_date', $act_current_date);
         $act_template->setValue('id', $id);
         $act_template->setValue('Date', $current_day);
         $act_template->setValue('Month', $current_month);
         $act_template->setValue('Year', $current_year);
         $act_template->setValue('pacient_name', $pacient_name);
         $act_template->setValue('passport_serie', $passport_serie);
         $act_template->setValue('passport_number', $passport_number);
         $act_template->setValue('passport_issued_date', $passport_issued_date);
         $act_template->setValue('residential_address', $residential_address);
         $act_template->setValue('service1', $service1);
         $act_template->setValue('q1', $q1);
         $act_template->setValue('price1', $price1);
         if($summary1 != ''){
          $act_template->setValue('summary1', $summary1);
        } else{
          $act_template->setValue('summary1', '');
          }

         $act_template->setValue('service2', $service2);
         $act_template->setValue('q2', $q2);
         $act_template->setValue('price2', $price2);
         if($summary2 != ''){
          $act_template->setValue('summary2', $summary2);
        } else{
          $act_template->setValue('summary2', '');
          }

         $act_template->setValue('service3', $service3);
         $act_template->setValue('q3', $q3);
         $act_template->setValue('price3', $price3);
         if($summary3 != ''){
          $act_template->setValue('summary3', $summary3);
        } else{
          $act_template->setValue('summary3', '');
          }

         $act_template->setValue('service4', $service4);
         $act_template->setValue('q4', $q4);
         $act_template->setValue('price4', $price4);
         if($summary4 != ''){
          $act_template->setValue('summary4', $summary4);
        } else{
          $act_template->setValue('summary4', '');
          }

         $act_template->setValue('service5', $service5);
         $act_template->setValue('q5', $q5);
         $act_template->setValue('price5', $price5);
         if($summary5 != ''){
          $act_template->setValue('summary5', $summary5);
        } else{
          $act_template->setValue('summary5', '');
          }

         $act_template->setValue('service6', $service6);
         $act_template->setValue('q6', $q6);
         $act_template->setValue('price6', $price6);
         if($summary6 != ''){
          $act_template->setValue('summary6', $summary6);
        } else{
          $act_template->setValue('summary6', '');
          }

          $act_template->setValue('summary', $summary);
          $act_name = 'act_' .  $current_date . '_' . $id . '.docx';
         // $doctor_translit_directory = translit($signed_person);
          $act_directory = 'acts/'  . $act_name; 
          $act_template->saveAs($act_directory);
         // echo "<div class='adm-modal-block'>";
         // echo "<span id='adm-modal-close-button'>X</span>";
          echo "Информация сохранена. Теперь Вы можете сохранить файлы, нажав на их название в колонке слева. Нажмите <a href='agreement'>сюда</a> для продолжения.";
        //  echo "</div>";
        //  echo "<div class='adm-overlay'></div>";
         }
        ?>
        <h2>СОЗДАНИЕ ДОГОВОРА</h2>
        <h3>Информация о пациенте</h3>
        <form method="post" action="agreement">
          <input type="text" class="form-control" maxlength="15" name="id" placeholder="Номер договора" size="15" value="<?php echo $id;?>"><br/>
          <input type="text" class="form-control" maxlength="50" name="pacient_name" placeholder="ФИО пациента" size="50" value="<?php echo $pacient_name;?>">
          <h4>Паспортные данные</h3>
          <label for="passport_serie">серия: <input type="text" class="form-control" maxlength="4" name="passport_serie" id="passport_serie" placeholder="0000" size="4" value="<?php echo $passport_serie;?>"></label>
          <label for="passport_number">номер: <input type="text" class="form-control" maxlength="6" name="passport_number"  placeholder="000000" size="6" value="<?php echo $passport_number;?>"></label>
          <label for="passport_issued_date">кем и когда выдан: <input type="text" class="form-control" maxlength="150" name="passport_issued_date"  placeholder="Место и дата выдачи паспорта" size="150" value="<?php echo $passport_issued_date;?>"></label>
          <h4>Контактные данные</h3>
          <input type="text" class="form-control" maxlength="100" name="residential_address" placeholder="Место фактического проживания" size="100" value="<?php echo $residential_address;?>"><br/>
          <input type="text" class="form-control" maxlength="20" name="phone" placeholder="Контактный телефон" size="20" value="<?php echo $phone;?>">
          <h3>Информация о предоставленных услугах</h3>
          <div id="services">
           <h4>Услуга 1</h4>
            <input list="service-name" class="form-control" name="service1" id="list" placeholder="Выберите наименование услуги из выпадающего списка" size="100" type="text" value="<?php echo $service1;?>"/>
            <datalist id="service-name">
              <option value="Трансназальная видегастроскопия К.М.Н."></option>
              <option value="Трансназальная видегастроскопия"></option>
              <option value="Фиброгастроскопия"></option>
              <option value="Видеоколоноскопия"></option>
              <option value="Фиброколоноскопия"></option>
              <option value="Первичная консультация врача и осмотр"></option>
              <option value="Первичная консультация врача с комплексным осмотром под видеоконтролем"></option>
              <option value="Консультация гастроэнтеролога (первичная)"></option>
              <option value="Консультация гастроэнтеролога (вторичная)"></option>
              <option value="Консультация гастроэнтеролога доктора медицинских наук(первичная)"></option>
              <option value="Консультация гастроэнтеролога доктора медицинских наук(вторичная)"></option>
              <option value="Патогистологическая биопсия"></option>
              <option value="Цитологическая биопсия"></option>
              <option value="Тест Helicobacter"></option>
              <option value="Видеозапись обследования на цифровой носитель"></option> 
            </datalist>
            <input type="text" class="form-control" name =      "q1" id =      "q1" placeholder="Количество" size="5" value="<?php      echo $q1;?>"/>
            <input type="text" class="form-control" name =  "price1" id =  "price1" placeholder="Цена" size="6" value="<?php        echo $price1;?>"/>
            <input type="text" class="form-control" name = "doctor1" id = "doctor1" placeholder="ФИО врача" size="50" value="<?php echo $doctor1;?>"/>
            <hr>
           <h4>Услуга 2</h4>
            <input list="service-name" class="form-control" name="service2" id="list" placeholder="Выберите наименование услуги из выпадающего списка" size="100" type="text" value="<?php echo $service2;?>"/>
            <datalist id="service-name">
              <option value="Трансназальная видегастроскопия К.М.Н."></option>
              <option value="Трансназальная видегастроскопия"></option>
              <option value="Фиброгастроскопия"></option>
              <option value="Видеоколоноскопия"></option>
              <option value="Фиброколоноскопия"></option>
              <option value="Первичная консультация врача и осмотр"></option>
              <option value="Первичная консультация врача с комплексным осмотром под видеоконтролем"></option>
              <option value="Консультация гастроэнтеролога (первичная)"></option>
              <option value="Консультация гастроэнтеролога (вторичная)"></option>
              <option value="Консультация гастроэнтеролога доктора медицинских наук(первичная)"></option>
              <option value="Консультация гастроэнтеролога доктора медицинских наук(вторичная)"></option>
              <option value="Патогистологическая биопсия"></option>
              <option value="Цитологическая биопсия"></option>
              <option value="Тест Helicobacter"></option>
              <option value="Видеозапись обследования на цифровой носитель"></option> 
            </datalist>
            <input type="text" class="form-control" name =      "q2" id =      "q2" placeholder="Количество" size="5" value="<?php      echo $q2;?>"/>
            <input type="text" class="form-control" name =  "price2" id =  "price2" placeholder="Цена" size="6" value="<?php        echo $price2;?>"/>
            <input type="text" class="form-control" name = "doctor2" id = "doctor2" placeholder="ФИО врача" size="50" value="<?php echo $doctor2;?>"/>
            <hr>
           <h4>Услуга 3</h4>
            <input list="service-name" class="form-control" name="service3" id="list" placeholder="Выберите наименование услуги из выпадающего списка" size="100" type="text" value="<?php echo $service3;?>"/>
            <datalist id="service-name">
              <option value="Трансназальная видегастроскопия К.М.Н."></option>
              <option value="Трансназальная видегастроскопия"></option>
              <option value="Фиброгастроскопия"></option>
              <option value="Видеоколоноскопия"></option>
              <option value="Фиброколоноскопия"></option>
              <option value="Первичная консультация врача и осмотр"></option>
              <option value="Первичная консультация врача с комплексным осмотром под видеоконтролем"></option>
              <option value="Консультация гастроэнтеролога (первичная)"></option>
              <option value="Консультация гастроэнтеролога (вторичная)"></option>
              <option value="Консультация гастроэнтеролога доктора медицинских наук(первичная)"></option>
              <option value="Консультация гастроэнтеролога доктора медицинских наук(вторичная)"></option>
              <option value="Патогистологическая биопсия"></option>
              <option value="Цитологическая биопсия"></option>
              <option value="Тест Helicobacter"></option>
              <option value="Видеозапись обследования на цифровой носитель"></option> 
            </datalist>
            <input type="text" class="form-control" name =      "q3" id =      "q3" placeholder="Количество" size="5" value="<?php      echo $q3;?>"/>
            <input type="text" class="form-control" name =  "price3" id =  "price3" placeholder="Цена" size="6" value="<?php        echo $price3;?>"/>
            <input type="text" class="form-control" name = "doctor3" id = "doctor3" placeholder="ФИО врача" size="50" value="<?php echo $doctor3;?>"/>
            <hr>
           <h4>Услуга 4</h4>
            <input list="service-name" class="form-control" name="service4" id="list" placeholder="Выберите наименование услуги из выпадающего списка" size="100" type="text" value="<?php echo $service4;?>"/>
            <datalist id="service-name">
              <option value="Трансназальная видегастроскопия К.М.Н."></option>
              <option value="Трансназальная видегастроскопия"></option>
              <option value="Фиброгастроскопия"></option>
              <option value="Видеоколоноскопия"></option>
              <option value="Фиброколоноскопия"></option>
              <option value="Первичная консультация врача и осмотр"></option>
              <option value="Первичная консультация врача с комплексным осмотром под видеоконтролем"></option>
              <option value="Консультация гастроэнтеролога (первичная)"></option>
              <option value="Консультация гастроэнтеролога (вторичная)"></option>
              <option value="Консультация гастроэнтеролога доктора медицинских наук(первичная)"></option>
              <option value="Консультация гастроэнтеролога доктора медицинских наук(вторичная)"></option>
              <option value="Патогистологическая биопсия"></option>
              <option value="Цитологическая биопсия"></option>
              <option value="Тест Helicobacter"></option>
              <option value="Видеозапись обследования на цифровой носитель"></option> 
            </datalist>
            <input type="text" class="form-control" name =      "q4" id =      "q4" placeholder="Количество" size="5" value="<?php      echo $q4;?>"/>
            <input type="text" class="form-control" name =  "price4" id =  "price4" placeholder="Цена" size="6" value="<?php        echo $price4;?>"/>
            <input type="text" class="form-control" name = "doctor4" id = "doctor4" placeholder="ФИО врача" size="50" value="<?php echo $doctor4;?>"/>
            <hr>
           <h4>Услуга 5</h4>
            <input list="service-name" class="form-control" name="service5" id="list" placeholder="Выберите наименование услуги из выпадающего списка" size="100" type="text" value="<?php echo $service5;?>"/>
            <datalist id="service-name">
              <option value="Трансназальная видегастроскопия К.М.Н."></option>
              <option value="Трансназальная видегастроскопия"></option>
              <option value="Фиброгастроскопия"></option>
              <option value="Видеоколоноскопия"></option>
              <option value="Фиброколоноскопия"></option>
              <option value="Первичная консультация врача и осмотр"></option>
              <option value="Первичная консультация врача с комплексным осмотром под видеоконтролем"></option>
              <option value="Консультация гастроэнтеролога (первичная)"></option>
              <option value="Консультация гастроэнтеролога (вторичная)"></option>
              <option value="Консультация гастроэнтеролога доктора медицинских наук(первичная)"></option>
              <option value="Консультация гастроэнтеролога доктора медицинских наук(вторичная)"></option>
              <option value="Патогистологическая биопсия"></option>
              <option value="Цитологическая биопсия"></option>
              <option value="Тест Helicobacter"></option>
              <option value="Видеозапись обследования на цифровой носитель"></option> 
            </datalist>
            <input type="text" class="form-control" name =      "q5" id =      "q5" placeholder="Количество" size="5" value="<?php      echo $q5;?>"/>
            <input type="text" class="form-control" name =  "price5" id =  "price5" placeholder="Цена" size="6" value="<?php        echo $price5;?>"/>
            <input type="text" class="form-control" name = "doctor5" id = "doctor5" placeholder="ФИО врача" size="50" value="<?php echo $doctor5;?>"/>
            <hr>
           <h4>Услуга 6</h4>
            <input list="service-name" class="form-control" name="service6" id="list" placeholder="Выберите наименование услуги из выпадающего списка" size="100" type="text" value="<?php echo $service6;?>"/>
            <datalist id="service-name">
              <option value="Трансназальная видегастроскопия К.М.Н."></option>
              <option value="Трансназальная видегастроскопия"></option>
              <option value="Фиброгастроскопия"></option>
              <option value="Видеоколоноскопия"></option>
              <option value="Фиброколоноскопия"></option>
              <option value="Первичная консультация врача и осмотр"></option>
              <option value="Первичная консультация врача с комплексным осмотром под видеоконтролем"></option>
              <option value="Консультация гастроэнтеролога (первичная)"></option>
              <option value="Консультация гастроэнтеролога (вторичная)"></option>
              <option value="Консультация гастроэнтеролога доктора медицинских наук(первичная)"></option>
              <option value="Консультация гастроэнтеролога доктора медицинских наук(вторичная)"></option>
              <option value="Патогистологическая биопсия"></option>
              <option value="Цитологическая биопсия"></option>
              <option value="Тест Helicobacter"></option>
              <option value="Видеозапись обследования на цифровой носитель"></option> 
            </datalist>
            <input type="text"  class="form-control" name =      "q6" id =      "q6" placeholder="Количество" size="5" value="<?php      echo $q6;?>"/>
            <input type="text"  class="form-control" name =  "price6" id =  "price6" placeholder="Цена" size="6" value="<?php        echo $price6;?>"/>
            <input type="text"  class="form-control" name = "doctor6" id = "doctor6" placeholder="ФИО врача" size="50" value="<?php echo $doctor6;?>"/>
            <hr>
          </div>
          <input type="text" name ="signed_person" class="form-control" id ="signed_person" placeholder="ФИО врача или медицинской сестры/лаборанта" size="100" value="<?php echo $signed_person;?>"/>
          <input type="submit" class="admin btn btn-primary" id="submit_agreement"  value="Сохранить в файл" name="submit-service">
        </form>
  </section>
<?
include_once 'inc/footer.php';
?>