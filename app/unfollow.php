<?php
include("connect_to_db.php");

$query = "MATCH (u:User)-[r:FOLLOWS]->(m:User) WHERE u.id = " .$_GET["user1"]. " and m.id = ".$_GET['user2']."\n
        DELETE r"; // Logged-in user unfollows current user
$client->sendCypherQuery($query)->getResult(); // Execute query

echo 'Follow';

