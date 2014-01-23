<?php
class Dictionary{
	private static $DICT = array(
			'TILTE_GENERAL' => 'Contacts system',
			'TILTE_USERS' => 'Users in the contact system',
			'TILTE_CONTACTS' => 'Contacts',
			'TILTE_CONTACTS_USER' => 'The contacts of %s',
			'TILTE_BIRTHDAYS' => 'Birthdays',
			'NO_RESULTS' => 'There are no results to match that filter'
	);
	public static function dictLookup($key){
		return isset(self::$DICT[$key]) ? self::$DICT[$key] : $key;
	}
}
?>