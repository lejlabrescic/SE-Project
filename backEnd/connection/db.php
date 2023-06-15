<?php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
if (!function_exists('getDatabaseConnection')) {
function getDatabaseConnection() {
    $servername = getenv('SERVERNAME');
    $username = getenv('USERNAME');
    $password = getenv('PASSWORD');
    $schema = getenv('SCHEMA'); 
    $port = "25060";
    $path = getenv('DRIVE');
    $options = array(
        PDO::MYSQL_ATTR_SSL_CA => $path,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,

    );
    $conn = new PDO("mysql:host=$servername; port=$port; dbname=$schema", $username, $password, $options);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
}
}
    