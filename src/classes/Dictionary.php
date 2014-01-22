<?php
class Dictionary{
	private static $DICT = array(
			'TILTE_GENERAL' => 'Contacts system',
			'TILTE_USERS' => 'Users',
			'TILTE_CONTACTS' => 'Contacts',
			'TILTE_BIRTHDAYS' => 'Birthdays',
	);
	public static function dictLookup($key){
		return isset(self::$DICT[$key]) ? self::$DICT[$key] : $key;
	}
}
?>