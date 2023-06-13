<?php
if (!function_exists('getDatabaseConnection')) {
function getDatabaseConnection() {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'project';

    $db = new mysqli($host, $username, $password, $database);

    // Check the connection
    if ($db->connect_errno) {
        die("Failed to connect to MySQL: " . $db->connect_error);
    }

    // Optional: Set the character set
    $db->set_charset("utf8");

    return $db;
}
}
