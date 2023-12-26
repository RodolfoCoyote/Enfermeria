<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.

session_start();
require_once "../connection_db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $measure = $_POST['measure'];
    $initial_stock = $_POST['initial_stock'];

    $sql = "UPDATE enf_supplies SET name = ?, measure = ?, initial_stock = ? WHERE id = ?;";
    $sql = $conn->prepare($sql);
    $sql->bind_param("ssii", $name, $measure, $initial_stock, $id);

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
