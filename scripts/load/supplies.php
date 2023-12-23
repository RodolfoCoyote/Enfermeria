<?php
session_start();
// Conectar a la base de datos
require_once '../connection_db.php';

$data_array = array();
$user_clinic = $_SESSION['user_clinic'];

// SQL para obtener los datos
if ($user_clinic == 5) {
    $sql = "SELECT id, name, measure, initial_stock, current_stock, initial_stock-current_stock AS abastecer FROM enf_supplies;";
} else {
    $sql = "SELECT id, name, measure, initial_stock, current_stock, initial_stock-current_stock AS abastecer FROM enf_supplies WHERE clinic = $user_clinic;";
}

$query = $conn->query($sql);

while ($data = $query->fetch_object()) {
    $opciones = '<button class="btn btn-primary ver_medicamento"><i class="fa fa-pencil"></i></button>';

    if ($data->abastecer > 0) {
        $opciones .= '<button class="btn btn-success btn_abastecer"><i class="fa fa-check"></i></button>';
    }

    $data_array[] = array(
        $data->id,
        $data->name,
        $data->measure,
        $data->initial_stock,
        $data->current_stock,
        $data->abastecer,
        $opciones
    );
}
// crear un array con el array de los datos, importante que esten dentro de : data
$new_array  = array("data" => $data_array);
// crear el JSON apartir de los arrays
echo json_encode($new_array);
