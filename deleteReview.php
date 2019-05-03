<?php
include_once('config.php');
// Include functions for application
include_once('functions.php');

$reviewID = get('reviewID');


$sql = file_get_contents('sql/deleteReview.sql');
$params = array('reviewID' => $reviewID);

    $statement = $database->prepare($sql);
    $statement->execute($params);

?>