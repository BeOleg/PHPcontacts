<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/src/classes/Config.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/src/classes/Dictionary.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/src/classes/Debugger.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/src/classes/Router.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/src/classes/DBLink.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/src/classes/DB.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/src/interfaces/ISerializer.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/src/serializers/serializers.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/src/classes/SerializerFactory.php');
	$viewValue = isset($_GET['view']) && $_GET['view'] ? $_GET['view'] : null;
?>