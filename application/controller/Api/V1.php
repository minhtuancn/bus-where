<?php

class Api_V1 extends Api_Base
{
  public function __construct()
  {
    parent::__construct();
  }
  
  public function index()
  {
    $this->_response('FAIL','The Endpoint is missing or invalid',400001);
  }
  
  public function check()
  {
    $this->_response('OK',array("time"=>strtotime(" ")));
  }
  
  public function places($req=null,$end1=null,$end2=null,$end3=null)
  {
    $allowed_params = array("q");
    
    if ($this->_params){
      foreach ($this->_params as $k=>$v){
        if (in_array($k,$allowed_params)){
          if ($k=='fields'){
            $param['fields'] = $v;
          } else if ($k=='sort'){
            $param['sort'] = $v;
          } else if ($k=='limit'){
            $param['limit'] = $v;
          } else if ($k=='page'){
            $param['page'] = $v;
          } else {
            $param['filter'][$k] = $v;
          }
        } else {
          $this->_response('FAIL','Invalid parameters found in the request. Please check for valid parameters.',400002);
        }
      }
    } else {
      $param = null;
    }
    
    $Place = new PlaceModel();
    
    if (isset($end1)){
      if (is_numeric($end1)){
        /** /places/{id} **/
        $result = $Place->selectPlaceData($end1,$param);
      } else {
        $this->_response('FAIL','Invalid Place ID. Place ID must be an integer.',400003);
      }
    } else if (isset($param['filter']['q'])){
      /** /places?q={name} **/
      $result = $Place->selectPlaceData_bySearch($param['filter']['q'],$param);
    } else {
      /** /places **/
      $result = $Place->selectPlacesList($param);
    }
    
    $this->_response('OK',$result);
  }
  
  public function services($req=null,$end1=null,$end2=null,$end3=null)
  {
    $allowed_params = array('distance','lat','lon');
    
    if ($this->_params){
      foreach ($this->_params as $k=>$v){
        if (in_array($k,$allowed_params)){
          if ($k=='fields'){
            $param['fields'] = $v;
          } else if ($k=='sort'){
            $param['sort'] = $v;
          } else if ($k=='limit'){
            $param['limit'] = $v;
          } else if ($k=='page'){
            $param['page'] = $v;
          } else {
            $param['filter'][$k] = $v;
          }
        } else {
          $this->_response('FAIL','Invalid parameters found in the request. Please check for valid parameters.',400004);
        }
      }
    } else {
      $param = null;
    }
    
    $BusService = new BusServiceModel();
    
    
    if (isset($end1) && $end1=='radial'){
      /** /services/radial **/
      $result = $BusService->selectNearbyBusServicesList($end1,$param);
    } else if (isset($end2)){
      if (is_numeric($end2)){
        /** /services/nearby/{id} **/
        $result = $BusService->selectNearbyBusServicesList($end2,$param);
      } else {
        $this->_response('FAIL','Invalid Place ID. Place ID must be an integer.',400005);
      }
    } else {
      /** /services **/
      $result = $BusService->selectBusServicesList($param);
    }
    
    $this->_response('OK',$result);
  }
  
  public function schedules($req=null,$end1=null,$end2=null,$end3=null)
  {
    $allowed_params = array();
    
    if ($this->_params){
      foreach ($this->_params as $k=>$v){
        if (in_array($k,$allowed_params)){
          if ($k=='fields'){
            $param['fields'] = $v;
          } else if ($k=='sort'){
            $param['sort'] = $v;
          } else if ($k=='limit'){
            $param['limit'] = $v;
          } else if ($k=='page'){
            $param['page'] = $v;
          } else {
            $param['filter'][$k] = $v;
          }
        } else {
          $this->_response('FAIL','Invalid parameters found in the request. Please check for valid parameters.',400006);
        }
      }
    } else {
      $param = null;
    }
    
    $BusSchedule = new BusScheduleModel();
    
    if (isset($end2) && isset($end3)){
      if (is_numeric($end3)){
        /** /schedules/arrival_time/{bus_id}/{stop_id} **/
        $result = $BusSchedule->selectTimeToArrive($end2,$end3,$param);
      } else {
        $this->_response('FAIL','Invalid Bus ID and/or Bus Stop ID.',400007);
      }
    } else {
      /** /services **/
      $result = $BusService->selectBusServicesList($param);
    }
    
    $this->_response('OK',$result);
  }
  
  public function bus_stops($req=null,$end1=null,$end2=null,$end3=null)
  {
    $allowed_params = array();
    
    if ($this->_params){
      foreach ($this->_params as $k=>$v){
        if (in_array($k,$allowed_params)){
          if ($k=='fields'){
            $param['fields'] = $v;
          } else if ($k=='sort'){
            $param['sort'] = $v;
          } else if ($k=='limit'){
            $param['limit'] = $v;
          } else if ($k=='page'){
            $param['page'] = $v;
          } else {
            $param['filter'][$k] = $v;
          }
        } else {
          $this->_response('FAIL','Invalid parameters found in the request. Please check for valid parameters.',400008);
        }
      }
    } else {
      $param = null;
    }
    
    $BusStop = new BusStopModel();
    
    if (isset($end1)){
      if (is_numeric($end1)){
        /** /bus_stops/{stop_id} **/
        $result = $BusStop->selectBusStopData($end1,$param);
      } else {
        $this->_response('FAIL','Invalid Bus Stop ID. Bus Stop ID must be an integer.',400009);
      }
    } else {
      /** /services **/
      $result = $BusService->selectBusServicesList($param);
    }
    
    $this->_response('OK',$result);
  }
}