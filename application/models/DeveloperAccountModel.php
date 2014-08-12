<?php

class DeveloperAccountModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function verifyAccessKey($access_key)
	{
		try {			
			if ($this->_memcache){
				$key = MEM.'verifyAccessKey'.$access_key;
				$cache_result = array();
				$cache_result = $this->_memcache->get($key);
				if ($cache_result){
					return $cache_result;
				}
			}
      
      $this->connectDB();
      $stmt = $this->db->prepare('
        SELECT accountID
        FROM developer_accounts
        WHERE access_key=? AND is_active=1
      ');
      $stmt->execute(array($access_key));
      $data = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if ($data){
        if ($this->_memcache) $this->_memcache->set($key, true, 3600);
        return true;
      }
      return false;
		} catch (Exception $e){
			error_log("File: \"". $e->getFile() ."\" Line: \"". $e->getLine()."\" Message: \"". $e->getMessage()."\"");
			return false;
		}
	}
  
	public function selectSecretKey($access_key)
	{
		if ($this->_memcache){
			$key = PROJ.'selectSecretKey'.$access_key;
			$cache_result = array();
			$cache_result = $this->_memcache->get($key);
			if ($cache_result){
				$AES = new AESEncryption();
				return $AES->aesDecrypt($cache_result);
			}
		}
		
		$this->connectDB();
		$stmt = $this->db->prepare('
			SELECT secret_key
			FROM developer_accounts
			WHERE access_key=? AND is_active=1
		');
		$stmt->execute(array($access_key));
		$data = $stmt->fetch(PDO::FETCH_COLUMN);
		
		if ($data){
			$AES = new AESEncryption();
			$secret_key = $AES->aesDecrypt($data);
			if ($this->_memcache) $this->_memcache->set($key, $data, 3600);
			return $secret_key;
		}
		return false;
	}
}
?>