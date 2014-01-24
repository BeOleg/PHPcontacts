<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/src/includes.php');
  if(!isset($_GET['endpoint']) || !$_GET['endpoint']){
    http_response_code(400); 
    throw new exception('Status code: 400');//Raise 400 error, bad request
  }
  	 
  $serializer = SerializerFactory::getSerializer($_GET['endpoint']);
  if($serializer && is_callable(array($serializer, 'getData'))){ //TODO: create abstract serializer class and to check that $serializer is instanceOf it
    $data = $serializer->getData($_GET);//get is actually supoer global, but nvm that, it is probper to pass the request as parameter to the serializer
  }
  else{
    http_response_code(400);
    throw new exception('Status code:  400');//raid 400, bad request, TODO: catch this exception, or replace it with exit()
  }

  if(isset($data) && isset($data['list']) && sizeof($data['list']) > 0){
  	Router::Render($_GET['endpoint'], $data);	
  }
  else{
  	Router::RenderEmptyResultSet($_GET['endpoint']);
  }
?> 