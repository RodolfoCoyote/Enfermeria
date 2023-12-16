<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.

$response = array();
try {
  $document_root = $_SERVER['DOCUMENT_ROOT'];
  // Establece la conexión a la base de datos (reemplaza con tus propios valores)
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "losreyesdelinjerto_com";


  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    throw new Exception("Error de conexión a la base de datos: " . $conn->connect_error);
  }
} catch (Exception $e) {
  $response['error'] = true;
  $response['message'] = $e->getMessage();
}
