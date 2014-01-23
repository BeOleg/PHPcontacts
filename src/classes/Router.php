<?php
class Router{
	/**
	*@description: Basic MVC router, open source by Oleg Tikhonov
	*/
	private static $VIEW_LOOKUP = array(
		'menu' => '/src/views/menu.php',
		'search' => '/src/views/search.php',
		'footer' => '/src/views/footer.php',

	);
	private static $CTRL_LOOKUP = array(
		'main' => '/src/controllers/main.php',//users list, where any user can see only himself, unless he is an admin
		'bdays' => '/src/controllers/bdays.php',//upcoming birthdays
		'contacts' => '/src/controllers/contacts.php'//searching your contacts, or everyone if you are an admin
	);
	private static $GLOBAL_STATICS = array(
		'css' => array('/static/lib/bootstrap/css/bootstrap.css', '/static/css/custom.css'),
		'js' =>  array('static/lib/jquery/jquery.min.js', 'static/lib/bootstrap/js/bootstrap.min.js', '/static/js/footer.js'),
	);
	private static $PAGE_SPECIFIC_STATICS = array(
		'contacts' => array('js' => array('/static/js/liveSearch.js')),
		'main' => array('js' => array('/static/js/liveSearch.js')),
		'bdays' => array('js' => array('/static/js/liveSearch.js')),
	);
	private static $ACTIVE_CLASS = "active";
	public static function includeView($param){
		if(isset(self::$VIEW_LOOKUP[$param]) && self::$VIEW_LOOKUP[$param]){
			require_once($_SERVER['DOCUMENT_ROOT'] . self::$VIEW_LOOKUP[$param]);
			return;
		}
	
	}
	public static function includeCtrl($param){
		if($param === null){
			require_once($_SERVER['DOCUMENT_ROOT'] . SEL:F:$CTRL_LOOKUP['main']);
			return;
		}
		if(isset(self::$CTRL_LOOKUP[$param]) && self::$CTRL_LOOKUP[$param]){
			require_once($_SERVER['DOCUMENT_ROOT'] . self::$CTRL_LOOKUP[$param]);
			return;
		}
		require_once($_SERVER['DOCUMENT_ROOT'] . self::$CTRL_LOOKUP['main']);//404, redirect to main page
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
				'bdays' => Dictionary::dictLookup('TILTE_BIRTHDAYS'),//searching your contacts, or everyone if you are an admin
				'contacts' => Dictionary::dictLookup('TILTE_CONTACTS'),//upcoming birthdays
				'__default' => Dictionary::dictLookup('TILTE_GENERAL'),
			);
		return isset($TITLE_LOOKUP[$route]) ? $TITLE_LOOKUP[$route] : $TITLE_LOOKUP['__default'];
	}
	public static function getStatics($route, $type){
		$route = $route == '' ? 'main' : $route;
		$specific_statics = isset(self::$PAGE_SPECIFIC_STATICS[$route]) && isset(self::$PAGE_SPECIFIC_STATICS[$route][$type]) && sizeof(self::$PAGE_SPECIFIC_STATICS[$route][$type]) > 0 ?
								 self::$PAGE_SPECIFIC_STATICS[$route][$type]  : array();
		$global_statics = isset(self::$GLOBAL_STATICS[$type]) && sizeof(self::$GLOBAL_STATICS[$type]) > 0 ?
								 self::$GLOBAL_STATICS[$type] : array();
		return array_merge($global_statics, $specific_statics);
	}
	public static function showSearchDialog($viewValue){
		$boolFlag = $viewValue == '' || $viewValue == 'main' || $viewValue == 'bdays' || $viewValue == 'contacts';
		return $boolFlag;
	}
	public static function render($ctrl, $data){
		$views = self::ctrlToView($ctrl);
		extract($data);
		require($_SERVER['DOCUMENT_ROOT'] . $views['header']);
		foreach($list as $__item){
			require($_SERVER['DOCUMENT_ROOT'] . $views['partial']);
		}
	}
	public static function RenderEmptyResultSet($ctrl){
		$views = self::ctrlToView($ctrl);
		require_once($_SERVER['DOCUMENT_ROOT'] . $views['header']);
		$phrase = Dictionary::dictLookup('NO_RESULTS');
		$msg = "<h4>{$phrase}</h4>";
		echo $msg;
	}
	private static function ctrlToView($ctrl){
		switch($ctrl){
			case 'users':
				return array('header' =>  '/src/views/usersHeader.php', 'partial' => '/src/views/partials/user.php');
			case 'main':
				return array('header' =>  '/src/views/usersHeader.php', 'partial' => '/src/views/partials/user.php');
			case 'contacts': 
				return array('header' =>  '/src/views/contactsHeader.php', 'partial' => '/src/views/partials/contact.php');
			case 'bdays':
				return array('header' =>  '/src/views/bdaysHeader.php', 'partial' => '/src/views/partials/bday.php');
			default: 
				return null;
		}
	}
}
?>