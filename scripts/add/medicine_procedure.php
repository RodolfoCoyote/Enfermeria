<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.

session_start();
require_once "../connection_db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $procedure_id = $_POST['procedure_id'];
    $medicine_id = $_POST['medicine_id'];
    $qty = $_POST['qty'];

    $timeString = $_POST['hour'];
    $timeObject = DateTime::createFromFormat('h:i A', $timeString);
    $timeFormatted = $timeObject->format('H:i:s');


    $comments = $_POST['comments'];
    $updated_by = $_SESSION['user_id'];

    $sql = "INSERT INTO enf_used_medicines (medicine_id, procedure_id, quantity, time, comments, updated_by) VALUES (?, ?, ?, ?, ?, ?);";
    $sql = $conn->prepare($sql);

    $sql->bind_param("iiissi", $medicine_id, $procedure_id, $qty, $timeFormatted, $comments, $updated_by);
    $success = ($sql->execute()) ? true : false;

    $sql = "UPDATE enf_medicines SET current_stock = current_stock - ? WHERE id = ?;";
    $sql = $conn->prepare($sql);

    $sql->bind_param("ii", $qty, $medicine_id);
    $success = ($sql->execute()) ? true : false;

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'Medicamento registrado correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Ocurrió un error. Contacta a administración.'
        ]);
    }
    // Cerrar la declaración y la conexión
    $sql->close();
}
