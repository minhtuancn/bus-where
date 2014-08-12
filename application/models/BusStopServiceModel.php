<?php

class BusStopServiceModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function selectServicesList($bus_stopID)
	{
		try {			
			if ($this->_memcache){
				$key = MEM.'selectServicesList'.$bus_stopID;
				$cache_result = array();
				$cache_result = $this->_memcache->get($key);
        return $cache_result['data'];
			}
      
			$this->connectDB();
			$stmt = $this->db->prepare('
				SELECT SS.bus_serviceID,SS.time_firstBus,SS.time_lastBus,P.name AS `from`, F.name AS `to`
        FROM bus_StopsServices SS
        JOIN places P
        ON P.placeID = SS.from_placeID
        JOIN places F
        ON F.placeID = SS.to_placeID
        WHERE SS.bus_stopID=?
			');
      $stmt->execute(array($bus_stopID));
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      if ($data){        
        $results['data']['count'] = count($data);
        $results['data']['services'] = $data;
      } else {
        $results['data'] = null;
      }
  
			if ($this->_memcache) $this->_memcache->set($key, $results, 3600);
			return $results['data'];
		} catch (Exception $e){
			error_log("File: \"". $e->getFile() ."\" Line: \"". $e->getLine()."\" Message: \"". $e->getMessage()."\"");
			return false;
		}
	}
}
?>