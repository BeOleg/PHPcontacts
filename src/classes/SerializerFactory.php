<?php
	class SerializerFactory{
		public static function getSerializer($endPoint){
			switch ($endPoint){
				case 'main':
					return new UserSerializer();
				case 'users':
					return new UserSerializer();
				case 'contacts':
					return new ContactSerializer();
				case 'birthdays':
					return new BirthDaySerializer();
				default:
					return null;
			}
		}		
	}
?>