<?php

class PlaceModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function selectPlaceData_bySearch($q,$param)
	{
		try {			
			if ($this->_memcache){
				$key = MEM.'selectPlaceID_bySearch'.$q;
				$cache_result = array();
				$cache_result = $this->_memcache->get($key);
				if ($cache_result['param'] == json_encode($param)){
          $data = $cache_result['data'];
        }
			}
      
      $q = strtolower($q);
      
			$this->connectDB();
			$stmt = $this->db->prepare('
				SELECT *
				FROM places
				WHERE LOWER(name) LIKE ?
			');
      $stmt->execute(array('%'.$q.'%'));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if ($data){
        $results['data']['place'] = $data;
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
	
	public function selectPlaceCoords($placeID)
	{
		try {			
			if ($this->_memcache){
				$key = MEM.'selectPlaceCoords'.$placeID;
				$cache_result = array();
				$cache_result = $this->_memcache->get($key);
				if ($cache_result){
					return $cache_result;
				}
			}
      
			$this->connectDB();
			$stmt = $this->db->prepare('
				SELECT lat,lon
				FROM places
				WHERE placeID=?
			');
      $stmt->execute(array($placeID));
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($this->_memcache) $this->_memcache->set($key, $data, 3600);
			return $data;
		} catch (Exception $e){
			error_log("File: \"". $e->getFile() ."\" Line: \"". $e->getLine()."\" Message: \"". $e->getMessage()."\"");
			return false;
		}
	}
}
?>