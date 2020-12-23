<?php
include("connect_to_db.php");

$query = "MATCH (u:User) WHERE u.id = " .$_GET["user1"]. "\n 
        MATCH (m:User) WHERE m.id = ".$_GET['user2']."\n 
        CREATE (u)-[:FOLLOWS]->(m)"; // Logged-in user follows current user
$client->sendCypherQuery($query)->getResult(); // Execute query

echo 'Unfollow';

