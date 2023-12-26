<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.

session_start();
require_once "../connection_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clinic = (isset($_POST['clinic_m'])) ? $_POST['clinic_m'] : $_POST['clinic_s'];
    $user_clinic = $_SESSION['user_clinic'];

    if ($clinic == $user_clinic || $user_clinic == 5) { // Permisos del usuario para la clínica (O permisos generales)

        $item_class = (isset($_POST['item_class_m']) && $_POST['item_class_m'] == "medicine") ? 'medicine' : 'supplie';
        if ($item_class == "medicine") {
            $name = $_POST['name_m'];
            $presentation = $_POST['presentation_m'];
            $dosage = $_POST['dosage_m'];
            $initial_stock = $_POST['initial_stock_m'];
            // Prepara la consulta
            $sql = $conn->prepare("INSERT INTO enf_medicines (name, presentation, dosage, clinic, initial_stock, current_stock) VALUES (?, ?, ?, ?, ?, ?)");
            // Vincula los parámetros
            $sql->bind_param("sssiii", $name, $presentation, $dosage, $clinic, $initial_stock, $initial_stock);
        } else if ($item_class = "supplie") {
            $name = $_POST['name_s'];
            $measure = $_POST['measure_s'];
            $initial_stock = $current_stock = $_POST['initial_stock_s'];
            $clinic = $_POST['clinic_s'];
            // Prepara la consulta
            $sql = $conn->prepare("INSERT INTO enf_supplies (name, measure, initial_stock, current_stock, clinic) VALUES (?, ?, ?, ?, ?)");
            // Vincula los parámetros
            $sql->bind_param("ssiii", $name, $measure, $initial_stock, $current_stock, $clinic);
        }

        if ($sql->execute()) {

            if ($sql->affected_rows > 0) {
                echo json_encode(["success" => true, "message" => "Elemento añadido correctamente"]);
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
