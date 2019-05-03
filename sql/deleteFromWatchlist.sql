SET SQL_SAFE_UPDATES=0;
DELETE FROM watchlists_items 
WHERE watchlists_items.watchlistid=:watchlistID AND watchlists_items.movieid=:movieID;