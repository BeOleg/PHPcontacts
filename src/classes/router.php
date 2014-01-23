<?php
class Router{
	/**
	*@description: Basic MVC router, freeware by Oleg Tikhonov
	*/
	private static $VIEW_LOOKUP = array(
		'main' => '/src/views/index.php',//users list, where any user can see only himself, unless he is an admin
		'bdays' => '/src/views/bdays.php',//upcoming birthdays
		'contacts' => '/src/views/search.php'//searching your contacts, or everyone if you are an admin
	);
	private static $TITLE_LOOKUP = array(

		'main' => Dictionary::dictLookup('TILTE_USERS'), //users list, where any user can see only himself, unless he is an admin
		'bdays' => Dictionary::dictLookup('TILTE_BIRTHDAYS'), //upcoming birthdays
		'contacts' => Dictionary::dictLookup('TILTE_CONTACTS'), //searching your contacts, or everyone if you are an admin
	);	
	public static function includeView($param){
		if($param === null){
			require_once($_SERVER['DOCUMENT_ROOT'] . self::$VIEW_LOOKUP['main']);
			return;
		}
		if(isset(self::$VIEW_LOOKUP[$param]) && self::$VIEW_LOOKUP[$param]){
			require_once($_SERVER['DOCUMENT_ROOT'] . self::$VIEW_LOOKUP[$param]);
			return;
		}

		require_once($_SERVER['DOCUMENT_ROOT'] . self::$VIEW_LOOKUP['main']);//404, redirect to main page
	}
	public static function isActivePath($param){
		$currPath = $_SERVER['REQUEST_URI'];		
		return strpos($currPath, $param) ? self::$ACTIVE_CLASS : '';
	}
	public static function getLink($route){
		$currPath = $_SERVER['REQUEST_URI'];
		return strpos($currPath, $route) ? '#' : '/' . $currLangPath . '/' . $route;
	}
	public static function getTitle($viewValue){
		// $currPath = trim($_SERVER['REQUEST_URI'], '/');
		if isset(SELF::$TITLE_LOOKUP[$viewValue]) ? SELF::$TITLE_LOOKUP[$viewValue] : Dictionary::dictLookup('TILTE_GENERAL');
	}
}
?>