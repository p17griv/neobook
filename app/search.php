<?php
include('connect_to_db.php');

if(isset($_GET["searchTerm"]) and !empty($_GET["searchTerm"])) {
    $query = "MATCH (u:User) WHERE u.fullname =~ '(?i)" . $_GET['searchTerm'] . ".*' RETURN u LIMIT 5"; // Get the 5 first fullnames that are equal or start with given term (Case-insensitive)
    $result = $client->sendCypherQuery($query)->getResult(); // Execute query

    echo '<div id="myDropdown" class="dropdown-content">';
    foreach ($result->getNodes() as $node) {
        echo '<a href="time-line.php?id=" >'.$node->getProperty('fullname').'</a>';
    }
    echo '</div>';
}