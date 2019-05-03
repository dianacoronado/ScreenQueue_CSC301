SELECT watchlists.name, watchlists.userid, watchlists.id, watchlists_items.movieid
FROM watchlists
INNER JOIN watchlists_items ON watchlists.id=watchlists_items.watchlistid
WHERE watchlists.userid = :userid AND watchlists_items.movieid =:movieid;