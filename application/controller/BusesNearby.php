<?php

class BusesNearby extends Controller
{
  public function index()
  {
    if (!isset($_GET['q'])){
      header('Location: /');
      exit;
    } else {
      $place_search = $_GET['q'];
      
      // search for place name match
      $placeData = $this->getAPIResults('/v1/places?q='.rawurlencode($place_search), 'GET');
      
      // Get nearby bus services
      $nearbyServicesList = $this->getAPIResults('/v1/services/nearby/'.$placeData['place']['placeID'].'?distance=1', 'GET');
      
      $this->render('buses-nearby', array(
        'metaTitle' => $nearbyServicesList['count'] . ' Buses near ' . $placeData['place']['name'],
        'metaDescription' => 'There are '.$nearbyServicesList['count'].' bus services about 1km in the vicinity of '.$placeData['place']['name'].'.',
        'placeData' => $placeData['place'],
        'nearbyServicesList' => $nearbyServicesList
      ));
    }
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