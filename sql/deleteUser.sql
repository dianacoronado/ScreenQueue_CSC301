SET SQL_SAFE_UPDATES=0;
DELETE FROM users 
WHERE users.userid = :userid;