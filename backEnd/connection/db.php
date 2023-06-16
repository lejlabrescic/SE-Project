<?php

if (!function_exists('getDatabaseConnection')) {
function getDatabaseConnection() {
    $servername = "sneakershopdatabase-do-user-14060163-0.b.db.ondigitalocean.com";
    $username = "doadmin";
    $password = "AVNS_XMzj_rh-d6O4UzIuI_3";
    $schema = "project";
    $port = 25060;
    $options = array(
        PDO::MYSQL_ATTR_SSL_CA => 'https://drive.google.com/file/d/1MUkSRJzi1ymOUzqmT2swP1JVMZ4tIEOa/view?usp=sharing',
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,

    );
    $conn = new PDO("mysql:host=$servername; port=$port; dbname=$schema", $username, $password, $options);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
}
}
    