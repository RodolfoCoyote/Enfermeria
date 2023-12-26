<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.

session_start();
require_once "../connection_db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['used_supplies_id'];
    $supply_id = $_POST['supply_id'];

    $qty = $_POST['qty'];
    $qtybackup = $_POST['qtybackup'];
    $comments = $_POST['comments'];

    $qty_updated = $qtybackup - $qty;

    $sql = "UPDATE enf_supplies SET current_stock = current_stock + ? WHERE id = ?;";
    $sql = $conn->prepare($sql);
    $sql->bind_param("ii", $qty_updated, $supply_id);
    $success = ($sql->execute()) ? true : false;

    $sql = "UPDATE enf_used_supplies SET quantity = ?, notes = ? WHERE id = ?";
    $sql = $conn->prepare($sql);

    $sql->bind_param("isi", $qty, $comments, $id);
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
