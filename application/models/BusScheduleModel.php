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
	
	public function populateBusSchedule()
	{
		try {
      // fetch list of bus services
      $busStopService = new BusStopServiceModel();
      $busStopServicesArr = $busStopService->selectBusStopServicesArray();
      
      $this->connectDB();
      $this->db->beginTransaction();      
      
      // get 10min interval of time from 5am to 12mn and date from 13Aug to 17Aug and populate with stopServiceID
      foreach ($busStopServicesArr as $k){
        $schedule = array();
        $syntax = '';
        for ($x=13;$x<=17;$x++){
          for ($i=5;$i<24;$i++){
            for ($j=0;$j<60;$j+=10){
              $syntax .= '(?,?),';
              $schedule[] = $k;
              $schedule[] = '2014-08-'.$x.' '.str_pad($i, 2, '0', STR_PAD_LEFT).':'.str_pad($j, 2, '0', STR_PAD_LEFT).':00';
            }
          }
        }
        $syntax = rtrim($syntax,',');
        
        $stmt = $this->db->prepare('
          INSERT IGNORE INTO bus_schedules(bus_stopServiceID,arrivalTime)
          VALUES'.$syntax.'
        ');
        $stmt->execute($schedule);
      }
      
      $this->db->commit();
			return true;
		} catch (Exception $e){
      $this->db->rollBack();
			error_log("File: \"". $e->getFile() ."\" Line: \"". $e->getLine()."\" Message: \"". $e->getMessage()."\"");
			return false;
		}
	}
}
?>