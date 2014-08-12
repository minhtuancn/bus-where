<?php

class Controller
{
  /**
  * METHOD: render()
  * This method will output your code to /application/views/{$view}
  */
  protected function render($view, $data_array=array())
  {
    // load Twig, the template engine
    // @see http://twig.sensiolabs.org
    $twig_loader = new Twig_Loader_Filesystem(PATH_VIEWS);
    $twig = new Twig_Environment($twig_loader, array(
      'cache' => PATH_VIEW_TWIG_CACHE,
      'auto_reload' => true
    ));
  
    // render a view while passing the to-be-rendered data
    echo $twig->render($view . PATH_VIEW_FILE_TYPE, $data_array);
    exit;
  }
  
  protected function displayError404()
  {
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
    $this->render('error404', array(
      'metaTitle' => 'Page not found',
      'metaDescription' => 'The page you\'re looking for may have been moved or deleted'	
    ));
  }
  
	protected function getAPIResults($endpoint, $method)
	{
		try {			
			$base_url = BUSWHERE_API;
      $access_key = BUSWHERE_ACCESS_KEY;
      $secret_key = BUSWHERE_SECRET_KEY;
			
			$timestamp = time();
			$hash = hash_hmac('sha256', $endpoint . $method . $access_key . $timestamp, $secret_key);
			$url = $base_url . $endpoint . ((strpos($endpoint,'?') !== false)? '&':'?') . 'access_key=' . $access_key . '&timestamp=' . $timestamp . '&hash=' . $hash;
      
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output=curl_exec($ch);
			curl_close($ch);
			
			$output = json_decode($output,true);
      
			if ($output['status']=='OK'){
				return $output['response'];
			} else {
				error_log("API Error[Code: \"". $output['code'] ."\". Message: \"". $output['message']."\". Detail: \"". $output['message_detail']."\" Request: \"". $output['request']."]");
				return false;
			}
		} catch (Exception $e){
			error_log("File: \"". $e->getFile() ."\" Line: \"". $e->getLine()."\" Message: \"". $e->getMessage()."\"");
			return false;
		}
	}
}