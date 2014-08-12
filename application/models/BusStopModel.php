<?php

class BusStopModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function selectBusStopData($bus_stopID, $param=null)
	{
		try {			
			if ($this->_memcache){
				$key = MEM.'selectBusStopData'.$bus_stopID;
				$cache_result = array();
				$cache_result = $this->_memcache->get($key);
				if ($cache_result['param'] == json_encode($param)){
          $data = $cache_result['data'];
        }
			}
      
			$this->connectDB();
			$stmt = $this->db->prepare('
				SELECT S.*
        FROM bus_stops S
        WHERE S.bus_stopID=?
			');
      $stmt->execute(array($bus_stopID));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if ($data){
        // get services under this bus stop
        $BusStopService = new BusStopServiceModel();
        $servicesList = $BusStopService->selectServicesList($bus_stopID);
        
        $results['data']['bus_stop'] = $data;
        $results['data']['bus_stop']['services'] = $servicesList;
      } else {
        $results['data'] = null;
      }
  
      $results['param'] = json_encode($param);
			if ($this->_memcache) $this->_memcache->set($key, $results, 3600);
			return $results['data'];
		} catch (Exception $e){
			error_log("File: \"". $e->getFile() ."\" Line: \"". $e->getLine()."\" Message: \"". $e->getMessage()."\"");
			return false;
		}
	}
}
?>