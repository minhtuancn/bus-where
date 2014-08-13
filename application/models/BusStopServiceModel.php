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
				$cache_result = array();//$this->_memcache->delete($key);
				$cache_result = $this->_memcache->get($key);
        if ($cache_result){
          return $cache_result;
        }
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
        $results['count'] = count($data);
        $results['services'] = $data;
      } else {
        $results = null;
      }
  
			if ($this->_memcache) $this->_memcache->set($key, $results, 3600);
			return $results;
		} catch (Exception $e){
			error_log("File: \"". $e->getFile() ."\" Line: \"". $e->getLine()."\" Message: \"". $e->getMessage()."\"");
			return false;
		}
	}
	
	public function selectBusStopServicesArray()
	{
		try {			
			if ($this->_memcache){
				$key = MEM.'selectBusStopServicesArray';
				$cache_result = array();//$this->_memcache->delete($key);
				$cache_result = $this->_memcache->get($key);
        if ($cache_result){
          return $cache_result;
        }
			}
      
			$this->connectDB();
			$stmt = $this->db->query('
				SELECT SS.bus_stopServiceID
        FROM bus_StopsServices SS
			');
			$data = $stmt->fetchAll(PDO::FETCH_COLUMN);
  
			if ($this->_memcache) $this->_memcache->set($key, $data, 1800);
			return $data;
		} catch (Exception $e){
			error_log("File: \"". $e->getFile() ."\" Line: \"". $e->getLine()."\" Message: \"". $e->getMessage()."\"");
			return false;
		}
	}
}
?>