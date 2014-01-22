<?php
require_once dirname(__FILE__) . '/../interfaces/ISerializer.php';
require_once dirname(__FILE__) . '/../classes/DBLink.php';
require_once dirname(__FILE__) . '/../classes/DB.php';

class UserSerializer implements ISerializer{
	public function getData($params=null){
		$serach = isset($params['search']) ? $params['search'] : null;
		return DB::getUsers($serach);
	}	
} 

class ContactSerializer implements ISerializer{
	public function getData($params=null){
		
	}	
} 

class BirthdaySerializer implements ISerializer{
	public function getData($params=null){
		
	}	
} 
?>