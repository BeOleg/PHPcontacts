CREATE TABLE IF NOT EXISTS users(
	id int(11) AUTO_INCREMENT PRIMARY KEY,
	role ENUM('user', 'admin'), 
	bday DATE, email VARCHAR(50), 
	first_name VARCHAR(20), 
last_name VARCHAR(30)
)
CHARACTER SET utf8 COLLATE utf8_general_ci;
ENGINE=InnoDB;


