<?php
require_once "./../WebDriver/phpwebdriver/WebDriver.php"; 

$webdriver = new WebDriver("http://localhost", "4444");
$webdriver->connect("mozilla firefox");
$webdriver->get("google.com"); 
?>
