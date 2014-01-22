CREATE TABLE IF NOT EXISTS contacts(
    contact_id INT, 
    user_id INT,
    INDEX uid (user_id),
    FOREIGN KEY (user_id) 
        REFERENCES users(id)
        ON DELETE CASCADE
)
ENGINE=InnoDB;
