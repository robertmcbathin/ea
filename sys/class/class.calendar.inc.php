<?
class Calendar extends DB_Connect
{
  private $_useDate;
  private $_m;
  private $_y;
  private $_daysInMonth;
  private $_startDay;
public function __construct($dbo=NULL, $useDate=NULL)
{
	parent::__construct($dbo);
  $set_names_sql = "SET NAMES 'utf8'";
  $stmt = $this->db->prepare($set_names_sql);
  $stmt->execute();
  $stmt->closeCursor();
	if (isset($useDate))
	{
		$this->_useDate = $useDate;
	}
	else
	{
      $this->_useDate = date('Y-m-d H:i:s');
	}
	$ts = strtotime($this->_useDate);
	$this->_m = date('m', $ts);
	$this->_y = date('Y', $ts);
	$this->_daysInMonth = cal_days_in_month(
		                  CAL_GREGORIAN, 
		                  $this->_m,
		                  $this->_y
		                  );
	$ts = mktime(0,0,0,$this->_m,1,$this->_y);
	$this->_startDay = date('w',$ts);
}

public function _loadEventData($id=NULL)
{  
   $sql = "SELECT `appointment`.`app_id`,`appointment`.`pacient_id`,`appointment`.`service_id`,`appointment`.`doctor_id`,`appointment`.`app_title`,`appointment`.`app_desc`,`appointment`.`status`,
          `appointment`.`conclusion`,`appointment`.`app_start`,`appointment`.`app_end`,`doctor`.`fio_full`,`doctor`.`fio_short`,`service`.`service_short_name`,`service`.`price`,`pacient`.`fio`,
          `pacient`.`phone`,`pacient`.`passport_serie`,`pacient`.`passport_number`,`pacient`.`passport_date_of_issue`,`pacient`.`passport_place_of_issue`,`pacient`.`place_of_residence`,`pacient`.`comment`
           FROM `appointment` 
           LEFT JOIN `service` ON `appointment`.`service_id`=`service`.`service_id` 
           LEFT JOIN  `doctor` ON `appointment`.`doctor_id`=`doctor`.`doctor_id` 
           LEFT JOIN `pacient` ON  `appointment`.`pacient_id`=`pacient`.`pacient_id`
           ";
   if(!empty($id))
   {
   	$sql .= "WHERE `appointment`.`app_id`=:id LIMIT 1";
   }
   else
   {
   	$start_ts = mktime(0,0,0,$this->_m,1,$this->_y);
   	$end_ts = mktime(23,59,59,$this->_m+1, 0,$this->_y);
   	$start_date = date('Y-m-d H:i:s', $start_ts);
   	$end_date = date('Y-m-d H:i:s', $end_ts);
   	$sql .= "WHERE `appointment`.`app_start` BETWEEN '$start_date'
                              AND '$end_date'
                              ORDER BY `appointment`.`app_start`";
   }
   try
   {
   	$stmt = $this->db->prepare($sql);
   	if (!empty($id))
   	{
   		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
   	}
   	$stmt->execute();
   	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
   	$stmt->closeCursor();
   	return $results;
   }
   catch ( Exception $e)
   {
   	die ($e->getMessage());
   }
}
/*---end _loadAgreementData--*/
public function _loadAgreementData($id)
{  
   $sql = "SELECT *
           FROM `agreement_act_data`
           WHERE `app_id` = '$id'
           ";
   try
   {
    $stmt = $this->db->prepare($sql);
    if (!empty($id))
    {
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    }
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $results;
  }
   catch ( Exception $e)
   {
    die ($e->getMessage());
   }
}
/*---end _loadEventData--*/
/*---start _loadServiceListData---*/
/*
*  Загрузка списка услуг
*/
public function _loadServiceListData()
{
  $results = array();
  $sql = "SELECT `service_full_name` FROM `service`";
  try {
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    while ($r = $stmt->fetch(PDO::FETCH_ASSOC))
        {
          $results[] = $r['service_full_name'];
        }
    $stmt->closeCursor();
    return $results;
  } catch (Exception $e) {
    die($e->getMessage());
  }
}
/*---end _loadServiceListData---*/
/*---start _loadDoctorListData---*/
/*
*  Загрузка списка врачей
*/
public function _loadDoctorListData()
{
  $results = array();
  $sql = "SELECT `fio_full` FROM `doctor`";
  try {
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    while ($r = $stmt->fetch(PDO::FETCH_ASSOC))
        {
          $results[] = $r['fio_full'];
        }
    $stmt->closeCursor();
    return $results;
  } catch (Exception $e) {
    die($e->getMessage());
  }
}
/*---end _loadDoctorListData---*/
private function _createAppObject()
{
	$arr = $this->_loadEventData();
	$apps = array();
	foreach ($arr as $app)
	{
     $day = date('j', strtotime($app['app_start']));
     try
     {
     	$apps[$day][] = new App($app);
     }
     catch (Exception $e)
     {
     	die($e->getMessage());
     }
	}
	return $apps;
}
/*---end _createAppObject--*/

/*Возвращает объект одиночного события*/
public function _loadAppById($id)
{
  if(empty($id))
  {
    return NULL;
  }
  $app = $this->_loadEventData($id);
  if(isset($app[0]))
  {
  	return new App($app[0]);
  }
  else
  {
  	return NULL;
  }
}

/*Выводит на экран и обрабатывает форму создания договора
input:
id - id назначения
output:


*/
public function createAgreement($id){
  if(empty($id)){return NULL;}
  $id = preg_replace('/[^0-9]/', '', $id);
  $app = $this->_loadAppById($id);
  print_r($app);
}
/*Функция проверки статуса назначения
*
*$st - статус назначения
*/
public function _checkStatus($st)
{
  $aClass == 'none';
  if($st == 'назначено')
  {
    $aClass = "list-group-item active";
    return $aClass;
  }
  elseif ($st == 'прием завершен') {
    $aClass = "list-group-item success";
    return $aClass;
  }
  elseif ($st == 'идет прием') {
    $aClass = "list-group-item alert";
    return $aClass;
  }
  elseif ($st == 'отменено') {
    $aClass = "list-group-item danger";
    return $aClass;
  }
}
  /*
* Разметка для административных ссылок
  */
private function _adminGeneralOptions()
{
  return <<<ADMIN_OPTIONS
  <a href="admin.php" class="admin btn btn-primary"> <span class="glyphicon glyphicon-plus"></span> Добавить назначение</a>
ADMIN_OPTIONS;
}
/* Редактирование и удаление событий с заданным id*/
private function _adminEntryOptions($id,$pacient_id)
{
  return <<<ADMIN_OPTIONS
    <div class="col-lg-6 col-sm-6">
      <form action="admin.php" method="post">
        <p>
          <input type="submit" class="btn btn-primary" name="edit_app" value="Редактировать назначение" />
          <input type="hidden" name="app_id" value="$id" />
        </p>
      </form>
      <form action="confirmdelete.php" method="post">
        <p>
          <input type="submit" name="delete_app" class="btn btn-primary" value="Удалить назначение"/>
          <input type="hidden" name="app_id" value="$id">
        </p>
      </form>
    </div>
    <div class="col-lg-6 col-sm-6">
    <form action="confirmcomplete.php" method="post">
        <p>
          <input type="submit" name="delete_app" class="btn btn-primary right-float" value="Завершить назначение"/>
          <input type="hidden" name="app_id" value="$id">
        </p>
      </form>
    </div>
ADMIN_OPTIONS;
}
  /*--------*/
  /*Построение календаря*/
public function buildCalendar()
{
	$cal_month = date('F Y', strtotime($this->_useDate));
	$weekdays = array('Воскресенье','Понедельник','Вторник','Среда','Четверг','Пятница','Суббота');
	$html = "\n\t<h2>$cal_month</h2>";
	for ($d=0, $labels=NULL; $d < 7; $d++) 
	{ 
		$labels .="\n\t\t<li class='calendar-ul'>" . $weekdays[$d] . "</li>";
	}
	$html .= "\n\t<ul class=\"weekdays\">" . $labels . "\n\t</ul>";
  /*Загрузка данных о событии*/
  $apps = $this->_createAppObject();
	/*HTML-разметка календаря*/
	$html .= "\n\t<ul>";
	for ($i=1, $c=1, $t=date('j'), $m=date('m'), $y=date('Y');
		$c<=$this->_daysInMonth; ++$i)
	{
		$class = $i<=$this->_startDay ? "fill" : NULL;
		if ($c==$t && $m==$this->_m && $y==$this->_y)
		{
			$class = "today";
		}
    $test = date('Y-m-d', mktime(0,0,0,$m,$c,$y));
    $as = "<a  href=\"calendar.php?day=" . $test . "\">";
		$ls = sprintf("\n\t\t<li class=\"%s\">", $class);
		$le = "\n\t\t</li>";
   // $ae = "</a>";
		if($this->_startDay<$i && $this->_daysInMonth>=$c)
		{
			/*Форматировать данные о событиях  view.php?app_id='. $app->id . '*/
			$app_info = NULL;
			if (isset($apps[$c]))
			{
				foreach ($apps[$c] as $app) 
				{
          $st = $this->_checkStatus($app->status);
				  $link = '<a class=' . '"' . $st . ' ' . 'get-app-data' . '" ' .  'data-fancybox-type="ajax" ' . 'data-id="' . $app->id . '"' . ' href="get_app_data.php?app_id=' . $app->id .'">' 
          . '<p align=\'left\'>' . $app->start_time . ' - ' . $app->end_time . ' (' . $app->service_short_name . ')' . '</p>'  . '</a>';
				  $app_info .= "\n\t\t\t$link";
          $app_info .= "\n\t\t\t<hr>$button";
				}
			}
			$date =  $as . sprintf("\n\t\t\t<strong><span class-\"glyphicon glyphicon-tasks\"></span> %02d</strong>", $c++) . "</a>";
		}
		else { $date="&nbsp;";}
		$wrap = $i!=0 && $i%7==0 ? "\n\t</ul>\n\t<ul>" : NULL;
		$html .= $ls . $date . $app_info . $le .  $wrap;
	}
	while ($i%7!=1) 
	{
		$html .= "\n\t\t<li class=\"fill\">&nbsp;</li>";
		++$i;
	}
	$html .= "\n\t</ul>\n\n";
  $admin = $this->_adminGeneralOptions();
	return $html . $admin;
}
/*--------------*/
/*Отоюражение информации о событии*/
public function displayApp($id)
{
	if(empty($id)){return NULL;}
	$id = preg_replace('/[^0-9]/', '', $id);
	$app = $this->_loadAppById($id);
  /*Запрос на существование договора и акта*/
  //$agreement_existence = $this->_loadAgreementData($id);
  $abs_act_path = "../www/docs/pacient/" . $app->pacient_id  . "/acts/akt_" . $app->id . "_" . $app->pacient_id . ".docx";
  $act_path = "/docs/pacient/" . $app->pacient_id  . "/acts/akt_" . $app->id . "_" . $app->pacient_id . ".docx";
  $abs_agreement_path = "../www/docs/pacient/" . $app->pacient_id  . "/agreements/dogovor_" . $app->id . "_" . $app->pacient_id . ".docx";
  $agreement_path = "/docs/pacient/" . $app->pacient_id  . "/agreements/dogovor_" . $app->id . "_" . $app->pacient_id . ".docx";
  if((file_exists($abs_agreement_path)) && (file_exists($abs_act_path)))
  {
    //show file link to save
    //show agreement fields
    $agreement_print_result = 
    "<div class=\"col-lg-4 col-sm-4\">
       <div class=\"panel panel-primary\">
         <div class=\"panel-heading\">ДОГОВОР</div>
         <div class=\"panel-body\">
           <div class=\"alert alert-info\" role=\"alert\">
               <span class=\"sr-only\"></span>
               <a href=\"$agreement_path\"><img src=\"/pictures/wordicon.png\">Договор</a>
           </div>
         </div>
       </div>
     </div>
     <div class=\"col-lg-4 col-sm-4\">
       <div class=\"panel panel-primary\">
         <div class=\"panel-heading\">АКТ</div>
         <div class=\"panel-body\">
           <div class=\"alert alert-info\" role=\"alert\">
               <span class=\"sr-only\"></span>
               <a href=\"$act_path\"><img src=\"/pictures/wordicon.png\">Акт</a>
           </div>
         </div>
       </div>
     </div>
     <div class=\"col-lg-4 col-sm-4\">
       <div class=\"panel panel-primary\">
         <div class=\"panel-heading\">ЗАКЛЮЧЕНИЕ</div>
         <div class=\"panel-body\">
           <div class=\"alert alert-danger\" role=\"alert\">
             <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
             <span class=\"sr-only\">Error:</span>
             Заключение отсутствует или еще не создано
           </div>
           <p>
             <a href=\"/create_conclusion?app_id=$id\" class=\"btn btn-primary right-float\">Создать заключение</a>
           </p>
         </div>
       </div>
     </div>";
  }
  else
  {
 // <a href=\"docs/$pacient_id/acts/qwe.docx\"><img src=\"pictures/wordicon.png\">Акт</a>  
    $agreement_print_result = 
    "<div class=\"col-lg-4 col-sm-4\">
       <div class=\"panel panel-primary\"><div class=\"panel-heading\">ДОГОВОР</div>
          <div class=\"panel-body\">
             <div class=\"alert alert-danger\" role=\"alert\">
               <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
               <span class=\"sr-only\">Error:</span>
               Договор отсутствует или еще не создан
             </div>
             <p>
             <a href=\"/create_agreement?app_id=$id\" class=\"btn btn-primary right-float\">Создать договор</a>
             </p>
         </div>
        </div>
      </div>
      <div class=\"col-lg-4 col-sm-4\">
        <div class=\"panel panel-primary\">
          <div class=\"panel-heading\">АКТ</div>
            <div class=\"panel-body\">
               <div class=\"alert alert-danger\" role=\"alert\">
                 <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
                 <span class=\"sr-only\">Error:</span>
                 Акт отсутствует или еще не создан. Акт создается вместе с договором
               </div>
            </div>
        </div>
      </div>
      <div class=\"col-lg-4 col-sm-4\">
        <div class=\"panel panel-primary\">
          <div class=\"panel-heading\">ЗАКЛЮЧЕНИЕ</div>
          <div class=\"panel-body\">
            <div class=\"alert alert-danger\" role=\"alert\">
              <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
              <span class=\"sr-only\">Error:</span>
              Заключение отсутствует или еще не создано
            </div>
            <p>
              <a href=\"/create_conclusion?app_id=$id\" class=\"btn btn-primary right-float\">Создать заключение</a>
            </p>
          </div>
        </div>
      </div>";
  }
  /*Конец запроса*/
  $pacient_id = $app->pacient_id;
  $service_id = $app->service_id;
  $doctor_id = $app->doctor_id;
	$ts = strtotime($app->start);
	$date = date('F d, Y',$ts);
	$start = date('G:i', $ts);
	$end = date('G:i',strtotime($app->end));
  $admin = $this->_adminEntryOptions($id,$pacient_id);
	//return "<h2>$app->pacient_fio <span class='label label-default'>$app->status</span></h2><br>"
  //      . "<h5>$app->service_short_name</h5><hr>"
	//      . "\n\t<p class=\"dates\">$date, $start&mdash;$end</p>"
  //      . "\n\t<p>$app->service_id" . " - " . "$app->doctor_id</p>"
	//      . "\n\t<p>$app->description</p>$admin";

  return "<div class=\"col-sm-12\">
            <div class=\"panel panel-primary\">
              <div class=\"panel-heading app-panel\">#$app->id | $app->service_short_name <br> $start - $end $date <span class=\"label label-info right-float\">$app->status</span></div>
              <div class=\"panel-body\">
                <p>Пациент: <strong><a href=\"/pacient?id=$app->pacient_id\">$app->pacient_fio</a></strong> Номер телефона:<strong>$app->pacient_phone</strong></p><hr>
                <p>Врач: <strong><a href=\"/doctor?id=$app->doctor_id\">$app->doctor_fio_full</a></strong> Услуга: <strong>$app->service_short_name</strong></p><hr>
                <p>Дополнительная информация: <strong>$app->description</strong></p>
                 <!-- <p>Заявка: <strong><a href=\"/request?id=$app->pacient_id\">$app->pacient_fio</a></strong></p> -->
              </div>
            </div>
          </div>
          $agreement_print_result
          $conclusion_print_result
          $admin
          ";
}
/*Форма редактирования и создания назначений*/
public function displayForm()
{
  $service_full_name = '';
  $doctor_full_name = '';
	if (isset($_POST['app_id']))
	{
		$id = (int) $_POST['app_id'];
	}
	else
	{
		$id = NULL;
	}
	$submit = "Создать назначение";
	if (!empty($id))
	{
		$app = $this->_loadAppById($id);
		if (!is_object($app)){return NULL;}
		$submit = "Изменить назначение";
	}
	return <<<FORM_MARKUP
	<form action="inc/process.inc.php" method="post">
	  <fieldset>
	    <legend>$submit</legend>
      <label for="pacient_list">Пациент</label>
      <div class="ui-widget">
        <input id="pacient_list" class="form-control" name="app_pacient" value="$app->pacient">
      </div>
      <label for="service_list">Услуга</label>
      <div class="ui-widget">
        <input class="form-control" id="service_list" name="service_list" value="$app->service_full_name">
      </div>
      <label for="service_list">Врач</label>
      <div class="ui-widget">
      <input  class="form-control" id="doctor_list" name="doctor_list" size="80" value="$app->doctor_fio_full">
      </div>
      <label for="app_date_start">Дата</label> 
      <input type="date" class="form-control" value="$app_date_start" name="app_date_start"> 
      <label for="app_time_start">Начало:</label> 
      <input type="time" class="form-control" size="10" value="$app_time_start" name="app_time_start"> 
      <label for="app_time_end">Конец:</label> 
      <input type="time" class="form-control" value="$app_time_end" name="app_time_end"> 
	    <label for="app_descrition">Описание</label>
	    <textarea name="app_descrition" cols="40" rows="10" class="form-control" id="app_descrition">
	    $app->description</textarea><br/>
	    <input type="hidden" name="app_id" value="$app->id"/>
      <input type="hidden" name="token" value="$_SESSION[token]"/>
      <input type="hidden" name="action" value="app_edit"/>
      <input type="submit" class="btn btn-primary" name="app_submit" value="$submit"/>
      или <a href="calendar">Отменить</a>
	  </fieldset>
	</form>
FORM_MARKUP;
  }
/*Проверка формы и сохрание или редактирование назначения*/
public function processForm()
{
	if ($_POST['action']!='app_edit')
		{return "Некорректная попытка вызова метода processForm()";}
  $pacient = $_POST['app_pacient'];
  $service = $_POST['service_list'];
  $doctor  = $_POST['doctor_list'];
  $date    = $_POST['app_date_start'];
  $start   = $_POST['app_time_start'] . ':00';
  $end     = $_POST['app_time_end'] . ':00';
	$desc    = $_POST['app_descrition'];
 /*Вставить подготовку запроса для вставки/изменения*/
  $p_id = '';//id пациента
  $s_id = '';//id услуги
  $d_id = '';//id врача
  /*----Запрос ID----*/
  $sql1 = "SELECT `pacient_id` FROM `pacient` WHERE `fio`='$pacient'";
  $stmt = $this->db->prepare($sql1);
  $stmt->execute();
  $r = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  /*IN CASE OF NEW PATIENT*/
  if($stmt->rowCount() == 0)
  {
    /*INSERT NEW PATIENT*/
    try {
      $sql_insert_new_pacient = "INSERT INTO `pacient` VALUES(null,'$pacient','','','','','','','','','','','','','','','')";
      $stmt = $this->db->prepare($sql_insert_new_pacient);
      $stmt->execute();
      $p_id = $this->db->lastInsertId();
      $stmt->closeCursor();
      mkdir("../docs/pacient/$p_id");
      mkdir("../docs/pacient/$p_id/acts");
      mkdir("../docs/pacient/$p_id/agreements");
      mkdir("../docs/pacient/$p_id/conclusions");
    } catch (PDOException $e) {
      die("<div class=\"alert alert-danger\" role=\"alert\">
         <span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span>
         <span class=\"sr-only\">Ошибка:</span>
         Не удалось создать карту пациента. Сначала создайте карту в разделе <a href=\"/card-index\">КАРТОТЕКА</a>.
       </div>");
    }
  }
  else $p_id = $r['pacient_id'];
  
  $sql2 = "SELECT `service_id` FROM `service` WHERE `service_short_name`='$service'";
  $stmt = $this->db->prepare($sql2);
  $stmt->execute();
  $r = $stmt->fetch(PDO::FETCH_ASSOC);
  $s_id = $r['service_id'];
  $stmt->closeCursor();

  $sql3 = "SELECT `doctor_id` FROM `doctor` WHERE `fio_full`='$doctor'";
  $stmt = $this->db->prepare($sql3);
  $stmt->execute();
  $r = $stmt->fetch(PDO::FETCH_ASSOC);
  $d_id = $r['doctor_id'];
  $stmt->closeCursor();
  /*---------конец запроса ID---------------*/
  /*Перевод date, start и end в datetime_start и datetime_end*/
  $datetime_start = $date . 'T' . $start . ':00' . '+00:00';
  $datetime_end = $date . 'T' . $end . ':00' . '+00:00';
  // (`pacient_id`, `service_id`, `doctor_id`, `app_desc`,`status`, `app_start`, `app_end`)
  $status = 'назначено';
	if(empty($_POST['app_id']))
	{
		$sql = "INSERT INTO `appointment` VALUES ('','$p_id','','$s_id','$d_id','','$desc','$status','','$datetime_start', '$datetime_end')";
	}
	else
	{
		$id = (int) $_POST['app_id'];
		$sql = "UPDATE `appointment`
		        SET 
               `pacient_id` = :p_id,
               `service_id`  = :s_id,
               `doctor_id` = :d_id,
		           `app_desc` = :description,
               `status` = :status,
		           `app_start` = :start,
		           `app_end` = :end WHERE `app_id`= $id";
	}
	try
	{
	    	$stmt = $this->db->prepare($sql);
        $stmt->execute();
	      $stmt->closeCursor();
	      return TRUE;
	}
	catch (Exception $e)
	{ 
      return $e->getMessage();
	}
} /*end processForm*/
public function confirmDelete($id)
{
  if(empty($id)){return NULL;}
  $id = preg_replace('/[^0-9]/', '', $id);
  if(isset($_POST['confirm_delete']) && $_POST['token']==$_SESSION['token'])
  {
    if($_POST['confirm_delete']=="Да, удалить")
    {
      $sql = "DELETE FROM `appointment`
              WHERE `app_id`=:id
              LIMIT 1";
      try
      {
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(
          ":id",
          $id,
          PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        header("Location: ./");
        die("<div class='container'><div class='alert alert-success'><p align='center'>Запись успешно удалена. </p></div></div>");
        return;
      }
      catch (Exception $e)
      {
        return $e->getMessage();
      }
    }
    else
    {
      header("Location: ./");
      return;
    }
  }
  $app = $this->_loadAppById($id);
  if(!is_object($app)){ header("Location: ./");}
  return <<<CONFIRM_DELETE
<form action="confirmdelete.php" method="post">
  <h2>Вы действительно хотите удалить назначение #"$app->id"?</h2>
  <p>Удаленное назначение <strong>невозможно восстановить</strong></p>
  <p>
    <input type="submit" class="btn btn-primary" name="confirm_delete" value="Да, удалить">
    <input type="submit" class="btn btn-primary" name="confirm_delete" value="Нет, я передумал(а)">
    <input type="hidden" name="app_id" value="$app->id">
    <input type="hidden" name="token" value="$_SESSION[token]">
  </p>
</form>
CONFIRM_DELETE;
}
/**
 * 
 */
public function confirmComplete($id)
{
  if(empty($id)){return NULL;}
  $id = preg_replace('/[^0-9]/', '', $id);
  if(isset($_POST['confirm_complete']) && $_POST['token']==$_SESSION['token'])
  {
    if($_POST['confirm_complete']=="Да, завершить")
    {
      $sql = "UPDATE `appointment`
              SET `status` = 'прием завершен'
              WHERE `app_id`=:id
              LIMIT 1";
      try
      {
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(
          ":id",
          $id,
          PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        header("Location: ./");
        die("<div class='container'><div class='alert alert-success'><p align='center'>Назначение успешно завершено. </p></div></div>");
        return;
      }
      catch (Exception $e)
      {
        return $e->getMessage();
      }
    }
    else
    {
      header("Location: ./");
      return;
    }
  }
  $app = $this->_loadAppById($id);
  if(!is_object($app)){ header("Location: ./");}
  return <<<CONFIRM_COMPLETE
  <form action="confirmcomplete.php" method="post">
    <h2>Вы действительно хотите завершить назначение #"$app->id"?</h2>
    <p>
      <input type="submit" class="btn btn-primary" name="confirm_complete" value="Да, завершить">
      <input type="submit" class="btn btn-primary" name="confirm_complete" value="Нет, я передумал(а)">
      <input type="hidden" name="app_id" value="$app->id">
      <input type="hidden" name="token" value="$_SESSION[token]">
    </p>
  </form>
CONFIRM_COMPLETE;
}
/**
 * 
 */
public function confirmDeleteService($id)
{
  if(empty($id)){return NULL;}
  $id = preg_replace('/[^0-9]/', '', $id);
  if(isset($_POST['confirm_delete']) && $_POST['token']==$_SESSION['token'])
  {
    if($_POST['confirm_delete']=="Да, удалить")
    {
      $sql = "DELETE FROM `service`
              WHERE `service_id`=:id
              LIMIT 1";
      try
      {
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(
          ":id",
          $id,
          PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        header("Location: ./");
        die("<div class='container'><div class='alert alert-success'><p align='center'>Запись успешно удалена. </p></div></div>");
        return;
      }
      catch (Exception $e)
      {
        return $e->getMessage();
      }
    }
    else
    {
      header("Location: ./");
      return;
    }
  }
  return <<<CONFIRM_DELETE
<form action="confirmdelete_service" method="post">
  <h2>Вы действительно хотите удалить данную услугу?</h2>
  <p>Данное действие <strong>необратимо</strong></p>
  <p>
    <input type="submit" class="btn btn-primary" name="confirm_delete" value="Да, удалить">
    <input type="submit" class="btn btn-primary" name="confirm_delete" value="Нет, я передумал(а)">
    <input type="hidden" name="service_id" value="$id">
    <input type="hidden" name="token" value="$_SESSION[token]">
  </p>
</form>
CONFIRM_DELETE;
}
/**
*/
public function confirmDeleteDoctor($id)
{
  if(empty($id)){return NULL;}
  $id = preg_replace('/[^0-9]/', '', $id);
  if(isset($_POST['confirm_delete']) && $_POST['token']==$_SESSION['token'])
  {
    if($_POST['confirm_delete']=="Да, удалить")
    {
      $sql = "DELETE FROM `doctor`
              WHERE `doctor_id`=:id
              LIMIT 1";
      try
      {
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(
          ":id",
          $id,
          PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        header("Location: ./");
        die("<div class='container'><div class='alert alert-success'><p align='center'>Запись успешно удалена. </p></div></div>");
        return;
      }
      catch (Exception $e)
      {
        return $e->getMessage();
      }
    }
    else
    {
      header("Location: ./");
      return;
    }
  }
  return <<<CONFIRM_DELETE
<form action="confirmdelete_doctor" method="post">
  <h2>Вы действительно хотите удалить данного врача из списка?</h2>
  <p>Данное действие <strong>необратимо</strong></p>
  <p>
    <input type="submit" class="btn btn-primary" name="confirm_delete" value="Да, удалить">
    <input type="submit" class="btn btn-primary" name="confirm_delete" value="Нет, я передумал(а)">
    <input type="hidden" name="doctor_id" value="$id">
    <input type="hidden" name="token" value="$_SESSION[token]">
  </p>
</form>
CONFIRM_DELETE;
}
/*------ПОДТВЕРЖДЕНИЕ УДАЛЕНИЯ ПОЛЬЗОВАТЕЛЯ-----*/
/**
*/
public function confirmDeleteUser($id)
{
  if(empty($id)){return NULL;}
  $id = preg_replace('/[^0-9]/', '', $id);
  if(isset($_POST['confirm_delete']) && $_POST['token']==$_SESSION['token'])
  {
    if($_POST['confirm_delete']=="Да, удалить")
    {
      $sql = "DELETE FROM `person`
              WHERE `person_id`=:id
              LIMIT 1";
      try
      {
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(
          ":id",
          $id,
          PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        header("Location: ./");
        die("<div class='container'><div class='alert alert-success'><p align='center'>Запись успешно удалена. </p></div></div>");
        return;
      }
      catch (Exception $e)
      {
        return $e->getMessage();
      }
    }
    else
    {
      header("Location: ./");
      return;
    }
  }
  return <<<CONFIRM_DELETE
<form action="confirmdelete_user" method="post">
  <h2>Вы действительно хотите удалить данного пользователя из списка?</h2>
  <p>Данное действие <strong>необратимо</strong></p>
  <p>
    <input type="submit" class="btn btn-primary" name="confirm_delete" value="Да, удалить">
    <input type="submit" class="btn btn-primary" name="confirm_delete" value="Нет, я передумал(а)">
    <input type="hidden" name="person_id" value="$id">
    <input type="hidden" name="token" value="$_SESSION[token]">
  </p>
</form>
CONFIRM_DELETE;
}
/*-----------*/
public function _loadPacientData()
  {
      $items = array();
      $sql = "SELECT `fio` FROM `pacient`";
      try
      {
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
     //   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC))
        {
          $items[$r['fio']] = $r['fio'];
        }
        $stmt->closeCursor();
       /* if(mysql_num_rows($sql) != 0)
        {
          while ($r = mysql_fetch_assoc($sql))
            { 
             $k = $r['fio'];
             $items[$k] = $r['fio'];
            }
        }*/
        return $items;  
      }
  catch (Exception $e)
  { 
      return $e->getMessage();
  }
      if(mysql_num_rows($sql) != 0)
       {
      while ($r = mysql_fetch_assoc($sql))
         { 
          $k = $r['fio'];
          $items[$k] = $r['fio'];
         }
       }
       return $items;
  }
/*Loading a service list*/
  public function _loadServiceData()
  {
      $items = array();
      $sql = "SELECT `service_short_name` FROM `service`";
      try
      {
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
     //   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC))
        {
          $items[$r['service_short_name']] = $r['service_short_name'];
        }
        $stmt->closeCursor();
       /* if(mysql_num_rows($sql) != 0)
        {
          while ($r = mysql_fetch_assoc($sql))
            { 
             $k = $r['fio'];
             $items[$k] = $r['fio'];
            }
        }*/
        return $items;  
      }
  catch (Exception $e)
  { 
      return $e->getMessage();
  }
      if(mysql_num_rows($sql) != 0)
       {
      while ($r = mysql_fetch_assoc($sql))
         { 
          $k = $r['service_short_name'];
          $items[$k] = $r['service_short_name'];
         }
       }
       return $items;
  }
  /**
   * [_loadDoctorData loading a list of doctors for autocomplete]
   * @return [array] [of full names]
   */
  public function _loadDoctorData()
  {
      $items = array();
      $sql = "SELECT `fio_full` FROM `doctor`";
      try
      {
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
     //   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        while ($r = $stmt->fetch(PDO::FETCH_ASSOC))
        {
          $items[$r['fio_full']] = $r['fio_full'];
        }
        $stmt->closeCursor();
       /* if(mysql_num_rows($sql) != 0)
        {
          while ($r = mysql_fetch_assoc($sql))
            { 
             $k = $r['fio'];
             $items[$k] = $r['fio'];
            }
        }*/
        return $items;  
      }
  catch (Exception $e)
  { 
      return $e->getMessage();
  }
      if(mysql_num_rows($sql) != 0)
       {
      while ($r = mysql_fetch_assoc($sql))
         { 
          $k = $r['fio_full'];
          $items[$k] = $r['fio_full'];
         }
       }
       return $items;
  }
  /**
   * [_getID Get the certain ID]
   * @param  [string] $type [pacient, doctor or service]
   * @param  [string] $name [pacient, doctor or service name]
   * @return [int]   $id    [certain ID]
   */
public function _getID($type,$name)
{
  switch ($type) {
    case 'pacient':
      $sql = "SELECT `pacient_id` FROM `pacient`
              WHERE `fio`='$name'";
      $stmt = $this->db->prepare($sql);
      $stmt->execute();
      $r = $stmt->fetch(PDO::FETCH_ASSOC);
      $id = $r['pacient_id'];
      $stmt->closeCursor();
      break;
    case 'doctor':
      $sql = "SELECT `doctor_id` FROM `doctor`
              WHERE `fio_full`='$name'";
      $stmt = $this->db->prepare($sql);
      $stmt->execute();
      $r = $stmt->fetch(PDO::FETCH_ASSOC);
      $id = $r['doctor_id'];
      $stmt->closeCursor();
      break;
    case 'service':
      $sql = "SELECT `service_id` FROM `service`
              WHERE `service_short_name`='$name'";
      $stmt = $this->db->prepare($sql);
      $stmt->execute();
      $r = $stmt->fetch(PDO::FETCH_ASSOC);
      $id = $r['service_id'];
      $stmt->closeCursor();
      break;
    default:
      # code...
      break;
  }
  return $id;
}
 /**
   * [_getPrice Get the price]
   * @param  [int] $service_id []
   * @return [float]   $id    []
   */
public function _getPrice($service_id)
{
  $sql = "SELECT `price` FROM `service`
          WHERE `service_id`='$service_id'";
  $stmt = $this->db->prepare($sql);
  $stmt->execute();
  $r = $stmt->fetch(PDO::FETCH_ASSOC);
  $price = $r['price'];
  $stmt->closeCursor();
  return $price;
}
 /**
   * [_getPriceByName Get the price]
   * @param  [string] $service_name []
   * @return [float]   $id    []
   */
public function _getPriceByName($service_name)
{
  $sql = "SELECT `price` FROM `service`
          WHERE `service_short_name`='$service_name'";
  $stmt = $this->db->prepare($sql);
  $stmt->execute();
  $r = $stmt->fetch(PDO::FETCH_ASSOC);
  $price = $r['price'];
  $stmt->closeCursor();
  return $price;
}
/**
 * [_getMonthByNumber] Get the Month name
 * @param [int] $number [Number of month (1-12)]
 * @return [string] $month_name ['Января', 'Февраля' и т.д.]
 */
public function _getMonthByNumber($number)
{
  $month_name = '';
  switch ($number) {
    case '1':
      $month_name = "Января";
      break;
    case '2':
      $month_name = "Февраля";
      break;
    case '3':
      $month_name = "Марта";
      break;
    case '4':
      $month_name = "Апреля";
      break;
    case '5':
      $month_name = "Мая";
      break;
    case '6':
      $month_name = "Июня";
      break;
    case '7':
      $month_name = "Июля";
      break;
    case '8':
      $month_name = "Августа";
      break;
    case '9':
      $month_name = "Сентября";
      break;
    case '10':
      $month_name = "Октября";
      break;
    case '11':
      $month_name = "Ноября";
      break;
    case '12':
      $month_name = "Декабря";
      break;
    
    default:
      break;
  }
  return $month_name;
}
/**
 * [_getUsersList] 
 * @return [array] array
 */
public function _getUsersList()
{
  $sql = "SELECT * FROM `person`";
  $stmt = $this->db->prepare($sql);
  $stmt->execute();
  return $stmt;
  $stmt->closeCursor();
}
/**
 * [_getPriceList] 
 * @return [array] array
 */
public function _getPriceList()
{
  $sql = "SELECT * FROM `service`";
  $stmt = $this->db->prepare($sql);
  $stmt->execute();
  return $stmt;
  $stmt->closeCursor();
}
/**
 * 
 */
public function _getDoctorList()
{
  $sql = "SELECT * FROM `doctor`";
  $stmt = $this->db->prepare($sql);
  $stmt->execute();
  return $stmt;
  $stmt->closeCursor();
}
/**
 * [_getService returns a row of data]
 * @param  [int] $id [service id]
 * @return [object]     [row of data]
 */
public function _getService($id)
{
  $sql = "SELECT * FROM `service`
          WHERE `service_id` = '$id'";
  $stmt = $this->db->prepare($sql);
  $stmt->execute();
  return $stmt;
  $stmt->closeCursor();
}
/**
 * [_getDoctor returns a row of data]
 * @param  [int] $id [doctor id]
 * @return [object]     [row of data]
 */
public function _getDoctor($id)
{
  $sql = "SELECT * FROM `doctor`
          WHERE `doctor_id` = '$id'";
  $stmt = $this->db->prepare($sql);
  $stmt->execute();
  return $stmt;
  $stmt->closeCursor();
}
/**
 * [_getUser returns a row of data]
 * @param  [int] $id [user id]
 * @return [object]     [row of data]
 */
public function _getUser($id)
{
  $sql = "SELECT * FROM `person`
          WHERE `person_id` = '$id'";
  $stmt = $this->db->prepare($sql);
  $stmt->execute();
  return $stmt;
  $stmt->closeCursor();
}
/*-----------------------------------------------------------------------------------------------------------------------------------------------*/
public function buildTimeline($c)
{
  $c = (int)$c;
  $apps = $this->_createAppObject();
  $html = "";
  $s_html = "";
  $html .= "<div class=\"container\">
              <div class=\"col-sm-1 col-md-1 col-lg-1 m-flex\">
                <table class=\"timeline\">
                  <th>Время</th>
                  <tr><td>8:00</td></tr>
                  <tr><td>8:30</td></tr>
                  <tr><td>9:00</td></tr>
                  <tr><td>9:30</td></tr>
                  <tr><td>10:00</td></tr>
                  <tr><td>10:30</td></tr>
                  <tr><td>11:00</td></tr>
                  <tr><td>11:30</td></tr>
                  <tr><td>12:00</td></tr>
                  <tr><td>12:30</td></tr>
                  <tr><td>13:00</td></tr>
                  <tr><td>13:30</td></tr>
                  <tr><td>14:00</td></tr>
                  <tr><td>14:30</td></tr>
                  <tr><td>15:00</td></tr>
                  <tr><td>15:30</td></tr>
                  <tr><td>16:00</td></tr>
                  <tr><td>16:30</td></tr>
                  <tr><td>17:00</td></tr>
                  <tr><td>17:30</td></tr>
                  <tr><td>18:00</td></tr>
                </table>
              </div>
              <div class=\"col-sm-11 col-md-11 col-lg-11 m-flex\"> ";
//  echo "<pre>";
//  print_r($apps);
//  echo "</pre>";
//  echo $c;
  if(isset($apps[$c]))
  {
    $services = array();
    foreach ($apps[$c] as $app) 
    {
      $services[] = $app->service_short_name;
    }
  }
  $services = array_unique($services);
  echo "<pre>";
  print_r($services);
  echo "</pre>";
  /**/
  $st_time = date('H:i',mktime(8,0,0,$this->_m,$c,$this->_y));
  $end_time = date('H:i',mktime(18,0,0,$this->_m,$c,$this->_y));
  echo $st_time . ' - ' . $end_time;
  foreach ($services as $service_name) {
    $s_html .= "<table><th class=\"table-head\">$service_name</th>";
    $prev_app_end = $st_time;
    foreach ($apps[$c] as $app) {
      if ($app->service_short_name == $service_name)
      {
        if ($app->start_time == $prev_app_end)
        {
          $busy_time_diff = (strtotime($app->end_time) - strtotime($app->start_time))/60 . "px";
          $s_html .= "<tr><td class=\"busy\" height=\"$busy_time_diff\"><a class=\"get-app-data app-data-link\" data-fancybox-type=\"ajax\" data-id=\"$app->id\" href=\"get_app_data.php?app_id=$app->id\">$app->start_time - $app->end_time | $app->doctor_fio_short | $app->pacient_fio</a></td></tr>";
          $prev_app_end = $app->end_time;
        } else if ($app->start_time > $prev_app_end)
        {
          echo "<br>";
          echo $app->start_time;
          echo ' ';
          echo $prev_app_end;
          /*-------------*/
          $spare_time_diff = (strtotime($app->start_time) - strtotime($prev_app_end))/60 . "px";
          $busy_time_diff = (strtotime($app->end_time) - strtotime($app->start_time))/60 . "px";
          echo "<br>$spare_time_diff - $busy_time_diff";
          $s_html .= "<tr><td class=\"spare\" height=\"$spare_time_diff\">Свободно $prev_app_end - $app->start_time</td></tr>"; 
          $s_html .= "<tr><td class=\"busy\" height=\"$busy_time_diff\"><a class=\"get-app-data app-data-link\" data-fancybox-type=\"ajax\" data-id=\"$app->id\" href=\"get_app_data.php?app_id=$app->id\">$app->start_time - $app->end_time | $app->doctor_fio_short | $app->pacient_fio</a></td></tr>";
          $prev_app_end = $app->end_time;
          echo ' ';
          echo $prev_app_end;
        }
      }
    }
    $s_html .= "</table>";
  }
  $html .= $s_html;
  $html .= "</div></div>";
  return $html;
}
public function buildTimelineOld($c)
{
  $current_app = '';
  $next_app = 'undefined';
  $html = "<h2>Timeline</h2>";
  $apps = $this->_createAppObject();
  if (isset($apps[$c]))
      {
        $services = array();
        $prev_serv = '';
        $next_serv = '';
        foreach ($apps[$c] as $app){              /*Список услуг. Далее составлять расписание по списку услуг */
          $prev_serv = $next_serv; 
          $next_serv = $app->service_short_name;
          if($next_serv != $prev_serv){
            $services[] = $next_serv;
          }
        }
        $app_info .= print_r($services);
        foreach ($apps[$c] as $app) 
        {
          $next_app = $app->service_short_name;
          $st = $this->_checkStatus($app->status);
       //   $next_app = $app->service_short_name;
 #     $link = '<a class=' . '"' . $st . '"' . ' href="view.php?app_id='
 #              . $app->id . '">' . $app->id . " | " . $app->title
 #              . '<br/>' . '<h4>' . $app->start_time . ' - ' . $app->end_time . '</h4> ' .  '</a>';
          if ($current_app == ''){
            $current_app = $app->service_short_name;
            $list_by_service = '<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">' . $current_app . '</h3>
            </div>
            <div class="panel-body">'; 
            for ($i=8; $i<=20;$i++){

              $min_time = date("H:i",mktime($i,0,0)); //начало интервала
              $max_time = $i + 1;
              $max_time = $max_time . ':00'; //конец интервала
              if (($app->start_time >= $min_time) && ($app->start_time<$max_time)){ 
                $list_by_service .= '<div class="row"><div class="col-md-1">' . $min_time . '</div>' . '<div class="col-md-11">' . $app->start_time . ' ' . $app->pacient_fio  . '</div></div>' ;
              }
              else{
                $list_by_service .= '<div class="row"><div class="col-md-1">' . $min_time . '</div>' . '<div class="col-md-11"></div></div>' ;
              }
            } 
            

          }
          else{
            if($current_app != $next_app){
              $list_by_service .= '</div></div>';
              $current_app = $app->service_short_name;
              $list_by_service .= '<div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">' . $current_app . '</h3>
                </div>
                <div class="panel-body">' . $app->id . ' ' . $app->pacient_fio . ' ' . $app->start_time; // контент
            }
            else{
              $list_by_service .= '<br/>' . $app->id . ' ' . $app->pacient_fio . ' ' . $app->start_time;
              $current_app = $app->service_short_name;
            }


          }  


     /*     elseif(($current_app != $next_app) && ($current_app!='')){
            $current_app = $app->service_short_name;
            $list_by_service .= '</div></div>g43';
            $list_by_service .= '<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">' . $current_app . '</h3>
            </div>
            <div class="panel-body">' . $app->id . ' ' . $app->pacient_fio . ' ' . $app->start_time; // контент
          }
          else{
            $current_app = $app->service_short_name;
        //    $list_by_service .= '</div></div>';
         //   $next_app = $app->service_short_name;
            if($next_app == $current_app){
              $list_by_service .= '<br/>' . $app->id . ' ' . $app->pacient_fio . ' ' . $app->start_time;
              
            }
            else{
              $list_by_service .= '</div></div>htr';

            }

          }*/
          $app_info .= "\n\t\t\t$list_by_service";
          $list_by_service = '';
         // $app_info .= "\n\t\t\t$list_by_service";
        }
      }
      else
        $html .= "<h3>Назначений на сегодня нет</h3>";
  $html .=  $app_info . '</div></div>';
  return $html;
}
/**
 * Checking for zero 
 */
public function checkZero($p,$q)
{
  $sum = '';
  $sum = $p * $q;
  if($sum==0) $sum='';
  return $sum;
}
/*-----------------------------------------------------------------------------------------------------------------------------------------------*/
}//end Class Calendar
?>