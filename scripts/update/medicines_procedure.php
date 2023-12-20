<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.

session_start();
require_once "../connection_db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $procedure_id = $_POST['procedure_id'];
    $medicine_id = $_POST['medicine_id'];
    $time = $_POST['hour'];
    $qty = $_POST['qty'];


    $sql = "UPDATE enf_used_medicines SET medicine_id = ?, procedure_id = ?, quantity = ?, time = ?, comments = ?, updated_by = ? WHERE id = ?";
    $sql = $conn->prepare($sql);

    $sql->bind_param("siisssi", $nombre_paciente, $tipo_injerto, $sala, $especialista, $fecha_proced, $observaciones, $id_procedure);
    $success = ($sql->execute()) ? true : false;

    $sql = "UPDATE enf_patients SET name = ?, type = ?, procedure_date = ? WHERE id = ?";
    $sql = $conn->prepare($sql);

    $sql->bind_param("sisi", $nombre_paciente, $tipo_injerto, $fecha_proced, $id_procedure);
    $success = ($sql->execute()) ? true : false;

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'Datos actualizados correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Ocurrió un error. Conta a administración.'
        ]);
    }
    // Cerrar la declaración y la conexión
    $sql->close();
}
