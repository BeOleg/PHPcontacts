<?php
require_once dirname(__FILE__) . '/../interfaces/ISerializer.php';
require_once dirname(__FILE__) . '/../classes/DBLink.php';
require_once dirname(__FILE__) . '/../classes/DB.php';//tjose ones are here for the serializers to be independent 

class UserSerializer implements ISerializer{
	public function getData($params=null){

		$search = isset($params['search']) ? $params['search'] : null;
		// $uid = isset($params['uid']) ? $uid : null;
		return  array('list' => DB::getUsers($search));
	}	
} 

class ContactSerializer implements ISerializer{
	public function getData($params=null){
		// exit('here');
		$uid = isset($params['uid']) ? $params['uid'] : null;
		$search = isset($params['search']) ? $params['search'] : null;
		return $uid ? array('list' => DB::getContactsByUser($uid, $search), '__fullName' => DB::getFullName($uid)) : 
					  array('list' => DB::getContacts($search), '__fullName' => null);//fullname can actually be taken from the result set, but it is more organized this way
	}	
} 

class BirthdaySerializer implements ISerializer{
	public function getData($params=null){
		$days = isset($params['days']) ? $params['days'] : Config::$DEFAULT_BDAY_RANGE;
		$search = isset($params['search']) ? $params['search'] : null;
		return  array('list' => DB::getContacts($search, $days));
	}	
} 
?>