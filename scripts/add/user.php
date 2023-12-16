<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.

session_start();
require_once "../connection_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Recolectar los datos del POST
	$name = $_POST['name'];
	$nickname = $_POST['nickname'];
	$password = $_POST['password'];
	$hashed_password = password_hash($password, PASSWORD_BCRYPT);
	$clinic = $_POST['clinic'];
	$privilegios = 1;
	// Prepara la consulta
	$sql = $conn->prepare("INSERT IGNORE INTO usuarios (nombre, usuario, contrasena, clinica, privilegios, ultimo_acceso) VALUES (?, ?, ?, ?, ?, NOW())");
	// Vincula los parámetros
	$sql->bind_param("sssii", $name, $nickname, $hashed_password, $clinic, $privilegios);

	if ($sql->execute()) {

		if ($sql->affected_rows > 0) {
			echo json_encode(["success" => true, "message" => "User created successfully"]);
		} else {
			echo json_encode(["success" => false, "message" => "User exists!"]);
		}
		// Cierra la conexión
		$conn->close();
	} else {
		echo json_encode(["success" => false, "message" => "Query Fail"]);
	}
}
