SELECT first_name, last_name, bday, YEAR(CURDATE())-YEAR(bday) as age_years 
FROM usesrs u1 WHERE u1.user_id IN (SELECT contact_id FROM contacts WHERE user_id = :uid) 
AND (CONCAT(first_name, ' ', last_name) LIKE :queryString OR CONCAT(last_name, ' ', first_name) LIKE :queryString