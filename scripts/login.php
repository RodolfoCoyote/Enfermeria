<?php
session_start();
require_once "connection_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$stmt = $conn->prepare("SELECT id, nombre, contrasena, clinica, privilegios FROM usuarios WHERE usuario = ?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $name, $hashed_password, $clinica, $privilegios);
		$stmt->fetch();

		if (password_verify($password, $hashed_password)) {
			$_SESSION['user_id'] = $id;
			$_SESSION['user_name'] = $name;

			$_SESSION['user_clinic'] = $clinica;
			$_SESSION['user_privileges'] = $privilegios;

			if (isset($_POST['rememberme']) && $_POST['rememberme'] == 'rememberme') {
				$token = bin2hex(random_bytes(32));
				$_SESSION['recordar_token'] = $token;

				setcookie('recordar_token', $token, time() + (86400 * 30), '/');
				echo json_encode([
					"message" => "success",
					"user_id" => $id,
					"user_name" => $name
				]);
			}
		} else {
			echo json_encode(["message" => "fail"]);
		}
	} else {
		echo json_encode(["message" => "fail"]);
	}

	$stmt->close();
}

$conn->close();
