<?php
include_once('config.php');
// Include functions for application
include_once('functions.php');

$watchlistID = get('listID');

$movieList = $user->getWatchlist($watchlistID);

//Delete all entries for the watchlist
foreach($movieList as $item)
{
    $sql = file_get_contents('sql/deleteFromWatchlist.sql');
    $params = array(
        'watchlistID' => $watchlistID,
        'movieID' => $item['movieid']
    );

    $statement = $database->prepare($sql);
    $statement->execute($params);
}

//delete watchlist
$sql = file_get_contents('sql/deleteWatchlist.sql');
$params = array('watchlistID' => $watchlistID);

$statement = $database->prepare($sql);
$statement->execute($params);

?>