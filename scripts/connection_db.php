<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.

$response = array();
$document_root = $_SERVER['DOCUMENT_ROOT'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "losreyesdelinjerto_com";


/* Produccion
$servername = "mysql.db.losreyesdelinjerto.com";
$username = "dblosreyesdelinj";
$password = "jFe4Uc8P";
$dbname = "db_losreyesdelinjerto_co";*/


$conn = new mysqli($servername, $username, $password, $dbname);
