<?
class Pacient extends DB_Connect
{
	public $fio;
	public function _loadPacientData()
	{
      $items = array();
      $sql = mysql_query("SELECT `fio` FROM `pacient`");
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
}
?>