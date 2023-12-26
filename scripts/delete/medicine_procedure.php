<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.

session_start();
require_once "../connection_db.php";
$sql_executed = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $item_id = $_POST['item_id'];
    $qtybackup = $_POST['qtybackup'];

    $sql = "DELETE FROM enf_used_medicines WHERE id = ?";
    $sql = $conn->prepare($sql);
    $sql->bind_param("i", $id);

    $success = ($sql->execute()) ? true : false;

    $sql = "UPDATE enf_medicines SET current_stock = current_stock + ? WHERE id = ?;";
    $sql = $conn->prepare($sql);
    $sql->bind_param("ii", $qtybackup, $item_id);

    $success = ($sql->execute()) ? true : false;

    $conn->close();

    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Registro eliminado correctamente']);
    } else {
        echo json_encode(["success" => false]);
    }
}
