<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.

session_start();
require_once "../connection_db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_procedure = $_POST['id_p'];
    $num_expediente = $_POST['num_expediente'];
    $nombre_paciente = $_POST['nombre_paciente'];
    $tipo_injerto = $_POST['tipo_injerto'];
    $sala = $_POST['sala'];
    $especialista = $_POST['especialista'];
    $observaciones = $_POST['observaciones'];

    $fecha_proced = $_POST['fecha_proced'];

    $sql = "UPDATE enf_procedures SET name = ?, type = ?, room = ?, specialist = ?, procedure_date = ?, notes = ? WHERE id = ?";
    $sql = $conn->prepare($sql);

    $sql->bind_param("siisssi", $nombre_paciente, $tipo_injerto, $sala, $especialista, $fecha_proced, $observaciones, $id_procedure);


    if ($sql->execute()) {
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
