<?php

// Check if no one is logged in
if (!isset($_COOKIE["user"])) {
    header('Location: landing.php'); // Redirect to landing.php
}
else {
    setcookie("user", "", time() - 3600, "/"); // Delete the cookie with the user's id as value
    header('Location: landing.php'); // Redirect to index.php
}
