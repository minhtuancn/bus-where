<?php
 
class Api_Base
{
  protected $_method;						  // Stores the HTTP Method used (GET/POST/DELETE/PUT)
  protected $_request;					  // Stores the full URL Parameters requested
  protected $_params;						  // Stores the endpoint parameters for processing
  protected $_endpoint;					  // API endpoint requested
  protected $_requestUrl;					// Request URL parameters
  
  public function __construct()
  {
    header("Access-Control-Allow-Orgin: *");
    header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");
    
    $this->_method = $_SERVER['REQUEST_METHOD'];
    if ($this->_method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
      if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
        $this->_method = 'DELETE';
      } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
        $this->_method = 'PUT';
      } else {
        $this->_response('FAIL','The requested method is invalid',405001);
      }
    }
    
    // Only allows for GET method
    switch($this->_method){
      case 'GET':
        $this->_request = $this->_cleanInputs($_GET);
        break;
      case 'POST':
        $this->_request = $this->_cleanInputs($_POST);
        break;
      default:
        $this->_response('FAIL','The requested method is invalid',405002);
        break;
    }
    
    $this->getApiEndpoint($this->_request['url']);
    $this->reBuildRequestUrl($this->_request);
    
    // if not https, to fail the request
    if (!($_SERVER['HTTP_HOST']=='buswhere.dev' || $_SERVER['HTTP_HOST']=='buswhere.mosufy.com') && HTTP_PROTOCOL=="http://"){
      error_log($_SERVER['HTTP_HOST']);
      $this->_response('FAIL','Unsecured HTTP not supported',405003);
    }
    
    if ($this->_endpoint=='/v1/ping'){
      $this->_response('OK',array("time"=>strtotime(" ")));
    }
    
    $DeveloperAccount = new \DeveloperAccountModel();
    
    if (!array_key_exists('access_key', $this->_request)) {
      $this->_response('FAIL','Access Key is missing or invalid',401001);
    } else if (!array_key_exists('timestamp', $this->_request)) {
      $this->_response('FAIL','Timestamp is missing or invalid',401002);
    } else if (!array_key_exists('hash', $this->_request)) {
      $this->_response('FAIL','Hash signature is missing or invalid',401003);
    } else if (!$DeveloperAccount->verifyAccessKey($this->_request['access_key'])) {
      $this->_response('FAIL','Wrong or invalid Access Key supplied',401004);
    } else if (!$this->validateHash($DeveloperAccount->selectSecretKey($this->_request['access_key']))){
      $this->_response('FAIL','Wrong or invalid signature supplied',401005);
    }
    
    $this->reBuildRequestUrl($this->_request);
  }
  
  /*
  * Authenticates the API Access
  * Checks for valid data signature
  * Checks for valid timeframe of 5mins
  * Checks for valid Method
  * Removes the auth parameters
  */
  protected function validateHash($secret_key)
  {
    $hash_build = hash_hmac('sha256', $this->_requestUrl . $this->_method . $this->_request['access_key'] . $this->_request['timestamp'], $secret_key);
    
    if ($hash_build == $this->_request['hash']){
      $timestamp_now = time();
      $time_diff = ($timestamp_now - $this->_request['timestamp'])/60; // 5 min expiry time
      if ($time_diff < 5){
        return true;
      }
    }
    return false;
  }
  
  /*
  * All responses will be in the format below
  * $status		= Either "OK" / "FAIL"
  * $data		= If $status=OK, $data will contain results. If $status=FAIL, $data will contain the message_details
  * $code		= The fail response code
  */
  public function _response($status, $data, $code=200)
  {
    $header_code = substr($code, 0, 3);
    header("HTTP/1.1 " . $code . " " . $this->_requestStatus($header_code));
    
    if ($status=="OK"){
      $result['status'] = $status;
      $result['request'] = $this->_requestUrl;
      $result['response'] = $data;
    } else {
      $result['status'] = $status;
      $result['request'] = $this->_requestUrl;
      $result['code'] = $code;
      $result['message'] = $this->_requestStatus($header_code);
      $result['message_detail'] = $data;
    }
    
    echo json_encode($result);
    exit;
  }
  
  protected function reBuildRequestUrl($request)
  {
    $endpoint = str_replace("api","",$request['url']);
    
    unset($request['url']);
    
    if (isset($request['access_key'])){
      $access_key = $request['access_key'];
      unset($request['access_key']);
    }
    if (isset($request['timestamp'])){
      $timestamp = $request['timestamp'];
      unset($request['timestamp']);
    }
    if  (isset($request['hash'])){
      $hash = $request['hash'];
      unset($request['hash']);
    }
    
    $endpoint .= (!empty($request)? '?' . urldecode(http_build_query($request, '', '&')):'');
    
    $this->_params = $request;
    $this->_requestUrl = str_replace(" ","%20",$endpoint);
    return true;
  }
    
  protected function getApiEndpoint($url)
  {
    $this->_endpoint = str_replace("api","",$url);
    return true;
  }
  
  private function _cleanInputs($data)
  {
    $clean_input = Array();
    if (is_array($data)) {
      foreach ($data as $k => $v) {
        $clean_input[$k] = $this->_cleanInputs($v);
      }
    } else {
      $clean_input = trim(strip_tags($data));
    }
    return $clean_input;
  }
  
  private function _requestStatus($code)
  {
    $status = array(  
      200 => 'Success',
      400 => 'Missing or invalid syntax',   
      401 => 'Missing or invalid signature',   
      404 => 'Not Found',   
      405 => 'Method Not Allowed',
      500 => 'Internal Server Error',
    ); 
    return ($status[$code])?$status[$code]:$status[500];
  }
}