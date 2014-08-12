<?php

class BusStopDirectory extends Controller
{
  public function index($bus_stopID=null,$map=false)
  {
    if ($map=='map'){
      $this->displayBusStopMap($bus_stopID);
    } else if ($bus_stopID){
      $this->displayBusStop($bus_stopID);
    }
    
    $this->render('bus-stop-directory', array(
      'metaTitle' => 'Bus Stop Directory | BusWhere',
      'metaDescription' => 'Millions of people have found the right bus to their next destination. Are you one of them?',
      'BusStopData' => $busStopData['bus_stop'],
      'page' => 'bus-stop-directory'
    ));
  }
  
  private function displayBusStop($bus_stopID)
  {      
    // Get bustop data
    $busStopData = $this->getAPIResults('/v1/bus_stops/'.$bus_stopID, 'GET');
        
    $this->render('bus-stop', array(
      'metaTitle' => 'Buses at Bus Stop '.$busStopData['bus_stop']['bus_stopID'].' - '.$busStopData['bus_stop']['name'],
      'metaDescription' => 'Millions of people have found the right bus to their next destination. Are you one of them?',
      'busStopData' => $busStopData['bus_stop'],
      'page' => 'bus-stop-directory'
    ));
  }
  
  private function displayBusStopMap($bus_stopID)
  {      
    // Get bustop data
    $busStopData = $this->getAPIResults('/v1/bus_stops/'.$bus_stopID, 'GET');
        
    $this->render('bus-stop-map', array(
      'metaTitle' => 'Buses at Bus Stop '.$busStopData['bus_stop']['bus_stopID'].' - '.$busStopData['bus_stop']['name'],
      'metaDescription' => 'Millions of people have found the right bus to their next destination. Are you one of them?',
      'busStopData' => $busStopData['bus_stop'],
      'page' => 'bus-stop-directory',
      'subPage' => 'bus-stop-map'
    ));
  }
	
  public function ajax_getBusTiming()
  {
    $busID = $_GET['busID'];
    $stopID = $_GET['stopID'];
    
    // get bus arrival time
    $arrivalTime = $this->getAPIResults('/v1/schedules/arrival_time/'.$busID.'/'.$stopID, 'GET');
    
    echo json_encode(array('time'=>$arrivalTime));
    exit;
  }
}