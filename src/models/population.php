<?php
	require_once(dirname(__FILE__) . '/../classes/Config.php');
	require_once(dirname(__FILE__) . '/../classes/Debugger.php');
	require_once(dirname(__FILE__) . '/../classes/DBLink.php');
	require_once(dirname(__FILE__) . '/../classes/DB.php');
	class Populate{
		/**
		*@description only run once, and make sure that there are no models \ data prior to running that script
		*run it from the CLI by typing php path/to/script/population.php in your command prompt
		*IMPORTANT: you will need to create the database which's name you can configure at the Config class before running this script
		*/
		//private static $schema = "CREATE DATABASE php_contacts";
		private static $tables = array(
			"CREATE TABLE IF NOT EXISTS contacts(
			    contact_id INT, 
			    user_id INT,
			    INDEX uid (user_id),
			    FOREIGN KEY (user_id) 
			        REFERENCES users(id)
			        ON DELETE CASCADE
			) 
			CHARACTER SET utf8 COLLATE utf8_general_ci;
			ENGINE=InnoDB;",

			"CREATE TABLE IF NOT EXISTS users(
				id int(11) AUTO_INCREMENT PRIMARY KEY,
				role ENUM('user', 'admin'), 
				bday DATE, email VARCHAR(50), 
				first_name VARCHAR(20), 
			last_name VARCHAR(30)
			)
			CHARACTER SET utf8 COLLATE utf8_general_ci;
			ENGINE=InnoDB;",
		);
		private static $users = array(
			array('first_name' => 'Oleg', 'last_name' => 'Tikhonov', 'email' => 'hellgy@gmail.com', 'bday' => '1990-12-11', 'role' => 'admin'),
			array('first_name' => 'Veronika', 'last_name' => 'Tikhonov', 'email' => 'veronika.tikhonov@gmail.com', 'bday' => '1987-3-11', 'role' => 'admin'),
			array('first_name' => 'Caroline', 'last_name' => 'Tenerre', 'email' => 'veronika.tikhonov@gmail.com', 'bday' => '1987-3-11', 'role' => 'user'),
			array('first_name' => 'Shaul', 'last_name' => 'Zindberg', 'email' => 'shaul.zindberg@gmail.com', 'bday' => '1987-1-28', 'role' => 'user'),
			array('first_name' => 'Mercedes', 'last_name' => 'Zindberg', 'email' => 'mercedes.zindberg@gmail.com', 'bday' => '1987-1-23', 'role' => 'user'),
			);
		private static $contacts = array(
				array('user_id' => 1, 'contact_id' => 2),
				array('user_id' => 1, 'contact_id' => 3),
				array('user_id' => 1, 'contact_id' => 4),
				array('user_id' => 1, 'contact_id' => 5),//oleg has everone as his contacts
				array('user_id' => 2, 'contact_id' => 1),
				array('user_id' => 2, 'contact_id' => 3),//veronica has Oleg and Caroline
				array('user_id' => 4, 'contact_id' => 5),
				array('user_id' => 4, 'contact_id' => 1),//Shaul has mercedes and oleg
				array('user_id' => 5, 'contact_id' => 1),
				array('user_id' => 5, 'contact_id' => 4),//Mercedes has Shaul and oleg
			);

		public function __construct(){
				foreach(self::$tables as $table){
					DB::exec($table);
				}
				DB::multipleInsert('users', self::$users);
				DB::multipleInsert('contacts', self::$contacts);
		}
	}


	$population = new Populate();

?>
