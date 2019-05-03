<?php
include_once('config.php');
// Include functions for application
include_once('functions.php');

$watchlistID = get('listID');
$movieID = get('movieID');


$sql = file_get_contents('sql/deleteFromWatchlist.sql');
    $params = array(
        'watchlistID' => $watchlistID,
        'movieID' => $movieID
    );

    $statement = $database->prepare($sql);
    $statement->execute($params);

?>