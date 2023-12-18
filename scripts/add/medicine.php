<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.

session_start();
require_once "../connection_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clinic = $_POST['clinic'];
    $user_clinic = $_SESSION['user_clinic'];

    if ($clinic == $user_clinic || $user_clinic == 5) { // Permisos del usuario para la clínica (O permisos generales)
        $name = $_POST['name'];
        $presentation = $_POST['presentation'];
        $dosage = $_POST['dosage'];
        $initial_stock = $_POST['initial_stock'];

        // Prepara la consulta
        $sql = $conn->prepare("INSERT INTO enf_medicines (name, presentation, dosage, clinic, initial_stock, current_stock) VALUES (?, ?, ?, ?, ?, ?)");
        // Vincula los parámetros
        $sql->bind_param("sssiii", $name, $presentation, $dosage, $clinic, $initial_stock, $initial_stock);

        if ($sql->execute()) {

            if ($sql->affected_rows > 0) {
                echo json_encode(["success" => true, "message" => "Medicamento añadido correctamente"]);
            } else {
                echo json_encode(["success" => false, "message" => "Contacta a Administración."]);
            }
            // Cierra la conexión
            $conn->close();
        } else {
            echo json_encode(["success" => false, "message" => "Contacta a Administración."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "No tienes permisos para esta clínica."]);
    }
}
