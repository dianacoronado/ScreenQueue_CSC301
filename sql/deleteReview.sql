SET SQL_SAFE_UPDATES=0;
DELETE FROM reviews 
WHERE reviews.id = :reviewID;