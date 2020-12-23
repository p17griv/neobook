<?php
include('connect_to_db.php');

if(isset($_GET["postId"])) {
    $postId = str_replace('likesNumber', '', $_GET["postId"]);

    $query = "MATCH (p:Post) WHERE p.id = ".$postId."\n
        SET p.likesCount = p.likesCount + 1"; // Increase current post's likes number by 1
    $client->sendCypherQuery($query)->getResult(); // Execute query

    $query = "MATCH (p:Post) WHERE p.id = ".$postId." RETURN p.likesCount"; // Get the number of likes
    $result = $client->sendCypherQuery($query)->getResult(); // Execute query
    echo $result->get('p.likesCount');
}