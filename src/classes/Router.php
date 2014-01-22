<?php
class Router{
	/**
	*@description: Basic MVC router, freeware by Oleg Tikhonov
	*/
	private static $VIEW_LOOKUP = array(
		'menu' => '/src/views/menu.php',
		'search' => '/src/views/search.php',
		'main' => '/src/views/main.php',//users list, where any user can see only himself, unless he is an admin
		'bdays' => '/src/views/bdays.php',//upcoming birthdays
		'contacts' => '/src/views/contacs.php'//searching your contacts, or everyone if you are an admin
	);
	private static $GLOBAL_STATICS = array(
		'css' => array('/static/lib/bootstrap/css/bootstrap.min.css', '/static/css/custom.css'),
		'js' =>  array('static/lib/jquery/jquery.min.js', '/static/js/footer.js'),
	);
	private static $PAGE_SPECIFIC_STATICS = array(
		'contacts' => array('js' => array('/static/js/liveSearch.js')),
		'main' => array('js' => array('/static/js/liveSearch.js')),
		'bdays' => array('js' => array('/static/js/liveSearch.js')),
	);
	
	public static function includeView($param, $isMainView = false){
		if($param === null){
			require_once($_SERVER['DOCUMENT_ROOT'] . self::$VIEW_LOOKUP['main']);
			return;
		}
		if(isset(self::$VIEW_LOOKUP[$param]) && self::$VIEW_LOOKUP[$param]){
			require_once($_SERVER['DOCUMENT_ROOT'] . self::$VIEW_LOOKUP[$param]);
			return;
		}
		if($isMainView)
			require_once($_SERVER['DOCUMENT_ROOT'] . self::$VIEW_LOOKUP['main']);//404, redirect to main page
	}
	public static function isActivePath($param){
		$currPath = $_SERVER['REQUEST_URI'];		
		return strpos($currPath, $param) ? self::$ACTIVE_CLASS : '';
	}
	public static function getLink($route){
		$currPath = $_SERVER['REQUEST_URI'];
		if($currPath == ''){
			return $route == 'main' ? '#' : '/';
		}
		return strpos($currPath, $route) ? '#' : '/' . $route;
	}
	public static function getTitle($route){
		$TITLE_LOOKUP = array(
				'main' => Dictionary::dictLookup('TILTE_GENERAL'),//users list, where any user can see only himself, unless he is an admin
				'bdays' => Dictionary::dictLookup('TILTE_CONTACTS'),//upcoming birthdays
				'contacts' => Dictionary::dictLookup('TILTE_BIRTHDAYS'),//searching your contacts, or everyone if you are an admin
				'__default' => Dictionary::dictLookup('TILTE_GENERAL'),
			);
		return isset($TITLE_LOOKUP[$route]) ? $TITLE_LOOKUP[$route] : $TITLE_LOOKUP['__default'];
	}
	public static function getStatics($route, $type){
		$specific_statics = isset(SELF::$PAGE_SPECIFIC_STATICS[$route]) && isset(SELF::$PAGE_SPECIFIC_STATICS[$route][$type]) && sizeof(SELF::$PAGE_SPECIFIC_STATICS[$route][$type]) > 0 ?
								 SELF::$PAGE_SPECIFIC_STATICS[$route][$type]  : array();
		$global_statics = isset(SELF::$GLOBAL_STATICS[$type]) && sizeof(SELF::$GLOBAL_STATICS[$type]) > 0 ?
								 SELF::$GLOBAL_STATICS[$type] : array();
		return array_merge($global_statics, $specific_statics);
	}
	public static function showSearchDialog($viewValue){
		return $viewValue == 'main' || $viewValue == 'bdays' || $viewValue == 'contacts';
	}
	public static function render($ctrl, $itmes){
		$partialPath = SELF::ctrlToView($ctrl);
		foreach($itmes as $__item){
			require($_SERVER['DOCUMENT_ROOT'] . $partialPath);
		}
	}
	private static function ctrlToView($ctrl){
		switch($ctrl){
			case 'users':
				return '/src/views/partials/user.php';
			case 'main':
				return '/src/views/partials/user.php';
			case 'contacts': 
				return '/src/views/partials/contacts.php';
			case 'bdays':
				return '/src/views/partials/bdays.php';
			default: 
				return null;
		}
	}
}
?>