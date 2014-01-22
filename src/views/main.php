<?php
$serializer = SerializerFactory::getSerializer('users');
$data = $serializer->getData();//get is actually supoer global, but nvm that, it is probper to pass the request as parameter to the serializer
Router::Render('users', $data)
?>
