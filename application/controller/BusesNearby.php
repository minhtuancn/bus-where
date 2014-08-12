<?php

class BusesNearby extends Controller
{
  public function index()
  {
    if (!(isset($_GET['q']) || isset($_GET['lat']) && isset($_GET['lon']))){
      header('Location: /');
      exit;
    } else {
      if (isset($_GET['q'])){
        $place_search = $_GET['q'];
        // search for place name match
        $placeData = $this->getAPIResults('/v1/places?q='.rawurlencode($place_search), 'GET');
        // Get nearby bus services
        $nearbyServicesList = $this->getAPIResults('/v1/services/nearby/'.$placeData['place']['placeID'].'?distance=1', 'GET');
      } else {
        $place_search = 'gps';
        $lat = $_GET['lat'];
        $lon = $_GET['lon'];
        // Get nearby bus services by radia distance
        $nearbyServicesList = $this->getAPIResults('/v1/services/radial/?lat='.$lat.'&lon='.$lon.'&distance=1', 'GET');
      }
      $this->render('buses-nearby', array(
        'metaTitle' => $nearbyServicesList['count'] . ' Buses near ' . (isset($placeData)? $placeData['place']['name']:'me'),
        'metaDescription' => 'There are '.$nearbyServicesList['count'].' bus services about 1km '. (isset($placeData)? 'in the vicinity of '.$placeData['place']['name']:'near me').'.',
        'placeData' => isset($placeData)? $placeData['place']:'',
        'nearbyServicesList' => $nearbyServicesList,
        'place_search' => $place_search
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