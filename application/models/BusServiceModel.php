<?php

class BusServiceModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function selectNearbyBusServicesList($placeID, $param)
	{
		try {			
			if ($this->_memcache){
				$key = MEM.'selectNearbyBusServicesList'.$placeID;
				$cache_result = array();
				$cache_result = $this->_memcache->get($key);
				if ($cache_result['param'] == json_encode($param)){
          $data = $cache_result['data'];
        }
			}
      
      $dist = intval($param['filter']['distance']);
      
      if ($placeID=='radial'){
        $lat = $param['filter']['lat'];
        $lon = $param['filter']['lon'];
      } else {
        // get coords of placeID
        $Place = new PlaceModel();
        $place_coord = $Place->selectPlaceCoords($placeID);
        $lat = $place_coord['lat'];
        $lon = $place_coord['lon'];
      }
      
			$this->connectDB();
			$stmt = $this->db->prepare('
				SELECT SB.bus_StopServiceID, B.bus_serviceID, S.bus_stopID, S.name, S.lat, S.lon, ACOS( SIN( RADIANS( lat ) ) * SIN( RADIANS( ? ) ) + COS( RADIANS( lat ) ) * COS( RADIANS( ? )) * COS( RADIANS( lon ) - RADIANS( ? )) ) * 6380 AS `distance`
        FROM bus_stops S
        JOIN bus_StopsServices SB
        ON SB.bus_stopID = S.bus_stopID
        JOIN bus_services B
        ON B.bus_serviceID = SB.bus_serviceID
        WHERE ACOS( SIN( RADIANS( lat ) ) * SIN( RADIANS( ? ) ) + COS( RADIANS( lat ) ) * COS( RADIANS( ? )) * COS( RADIANS( lon ) - RADIANS( ? )) ) * 6380 < ?
        ORDER BY CAST(B.bus_serviceID AS SIGNED INTEGER) ASC, distance ASC
			');
      $stmt->execute(array($lat,$lat,$lon,$lat,$lat,$lon,$dist));
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      if ($data){
        foreach ($data as $k=>$v){
          $data[$k]['distance'] = round($v['distance'],2); 
        }
        $results['data']['count'] = count($data);
        $results['data']['services'] = $data;
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