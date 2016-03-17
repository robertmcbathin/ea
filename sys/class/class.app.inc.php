<?
  class App
  {
  	public $id;
    public $pacient_id;
    public $service_id;
    public $doctor_id;
  	public $title;
  	public $description;
  	public $start;
  	public $end;
    public $start_time;
    public $end_time;
    public $status;
    public $conclusion;
    /*doctor*/
    public $doctor_fio_full;
    public $doctor_fio_short;
    /**/
    /*service*/
    public $service_short_name;
    public $price;
    /**/
    /*pacient*/
    public $pacient_fio;
    public $pacient_phone;
    public $pacient_comment;
    /**/

  	public function __construct($app)
  	{
  		if (is_array($app))
  		{
           $this->id = $app['app_id'];
           $this->pacient_id = $app['pacient_id'];
           $this->service_id = $app['service_id'];
           $this->doctor_id = $app['doctor_id'];
           $this->title = $app['app_title'];
           $this->description = $app['app_desc'];
           $this->start = $app['app_start'];
           $start = strtotime($this->start);
           $this->start_time = date("H:i", $start);
           $this->end = $app['app_end'];
           $end = strtotime($this->end);
           $this->end_time = date("H:i", $end);
           $this->status = $app['status'];
           $this->conclusion = $app['conclusion'];
           /*doctor*/
           $this->doctor_fio_full = $app['fio_full'];
           $this->doctor_fio_short = $app['fio_short'];
           /**/
           /*service*/
           $this->service_short_name = $app['service_short_name'];
           $this->price = $app['price'];
           /**/
           /*pacient*/
           $this->pacient_fio = $app['fio'];
           $this->pacient_phone = $app['phone'];
           $this->pacient_passport_serie = $app['passport_serie'];
           $this->pacient_passport_number = $app['passport_number'];
           $this->pacient_passport_date_of_issue = $app['passport_date_of_issue'];
           $this->pacient_passport_place_of_issue = $app['passport_place_of_issue'];
           $this->pacient_place_of_residence = $app['place_of_residence'];
           $this->pacient_comment = $app['comment'];
           /**/
  		}
  		else
  		{
  			throw new Exception("Не были предоставлены данные о событии.");
  		}
  	}
  }
?>