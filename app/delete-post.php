<?php
include('connect_to_db.php');

if(isset($_GET["postId"])) {

    $query = "MATCH (p:Post) WHERE p.id = ".$_GET['postId']."\n
        DETACH DELETE p"; // Delete current post
    $client->sendCypherQuery($query); // Execute query
}