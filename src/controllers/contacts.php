<?php
$serializer = SerializerFactory::getSerializer('contacts');
// $user_id = isset($_GET['uid']) ? $_GET['uid'] : null;
$data = $serializer->getData($_GET);//get is actually supoer global, but nvm that, it is probper to pass the request as parameter to the serializer

if($data && $data['list'] && sizeof($data['list']) > 0)
	Router::Render('contacts', $data);
else
	Router::RenderEmptyResultSet('contacts');
?>