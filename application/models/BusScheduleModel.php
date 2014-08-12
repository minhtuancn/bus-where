<?php

class BusScheduleModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function selectTimeToArrive($busID,$stopID,$param)
	{
		try {
      $curr_time = date('Y-m-d H:i:s',strtotime(' '));
      
			$this->connectDB();
			$stmt = $this->db->prepare('
				SELECT BS.arrivalTime
        FROM bus_schedules BS
        JOIN bus_StopsServices SS
        ON BS.bus_StopServiceID = SS.bus_StopServiceID
        WHERE SS.bus_serviceID=? AND SS.bus_stopID=? AND BS.arrivalTime>=?
        ORDER BY BS.arrivalTime ASC
        LIMIT 0,1
			');
      $stmt->execute(array($busID,$stopID,$curr_time));
			$arrivalTime = $stmt->fetch(PDO::FETCH_COLUMN);
      
      if ($arrivalTime){
        $curr_time = strtotime($curr_time);
        $arr_time = strtotime($arrivalTime);
        $diff = $arr_time - $curr_time;
        $arrivalTime = round($diff/60);
        
        if ($arrivalTime==0){
          $arrivalTime = 'Arr';
        } else if ($arrivalTime<0){
          $arrivalTime = 'NA';
        }
      } else {
        $arrivalTime = 'NA';
      }
      
			return $arrivalTime;
		} catch (Exception $e){
			error_log("File: \"". $e->getFile() ."\" Line: \"". $e->getLine()."\" Message: \"". $e->getMessage()."\"");
			return false;
		}
	}
}
?>