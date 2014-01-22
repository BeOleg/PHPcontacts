<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/src/includes.php');
  if(!isset($_GET['endpoint']) || !$_GET['endpoint'])
  	 throw new exception('400');
  $serializer = SerializerFactory::getSerializer($_GET['endpoint']);
  $data = $serializer->getData($_GET);//get is actually supoer global, but nvm that, it is probper to pass the request as parameter to the serializer
  if(isset($data) && sizeof($data) > 0){
  	Router::Render($_GET['endpoint'], $data);	
  }
  else{
  	Router::RenderEmptyResultSet();
  }
?> 