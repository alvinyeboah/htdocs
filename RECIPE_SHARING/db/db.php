<?php
require_once 'config.php';
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
$connection->set_charset("utf8");
if (DEBUG_MODE) {
    // echo "Database connection successful!";
}
