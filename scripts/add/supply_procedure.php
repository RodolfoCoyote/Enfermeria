<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.

session_start();
require_once "../connection_db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $procedure_id = $_POST['procedure_id'];
    $supply_id = $_POST['supply_id'];
    $qty = $_POST['qty'];
    $comments = $_POST['comments'];

    $sql = "INSERT INTO enf_used_supplies (supply_id, procedure_id, quantity, notes) VALUES (?, ?, ?, ?);";
    $sql = $conn->prepare($sql);

    $sql->bind_param("iiis", $supply_id, $procedure_id, $qty, $comments);
    $success = ($sql->execute()) ? true : false;

    $sql = "UPDATE enf_supplies SET current_stock = current_stock - ? WHERE id = ?;";
    $sql = $conn->prepare($sql);

    $sql->bind_param("ii", $qty, $supply_id);
    $success = ($sql->execute()) ? true : false;

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'Insumo registrado correctamente'
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
