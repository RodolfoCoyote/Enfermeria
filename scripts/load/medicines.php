<?php
session_start();
// Conectar a la base de datos
require_once '../connection_db.php';

$data_array = array();
// SQL para obtener los datos
$sql = "SELECT *, cantidad_sala-cantidad_actual as abastecer, 
    IF(cantidad_sala-cantidad_actual=0,
        CONCAT('<button class=\'btn btn-primary ver_medicamento\' medicamento_id=',id,'><i class=\'bi bi-pencil\'></i></button>'),
        CONCAT('<button class=\'btn btn-primary ver_medicamento\' medicamento_id=',id,'><i class=\'bi bi-pencil\'></i></button>
                <button class=\'btn btn-success btn_abastecer\' medicamento_id=',id,'><i class=\'bi bi-check-lg\'></i></button>')) 
        AS opciones FROM medicamentos;";
// Ejeuctar el SQL
$query = $conn->query($sql);
// Recorrer los resultados
while ($data = $query->fetch_object()) {

    // Poner los datos en un array en el orden de los campos de la tabla
    $data_array[] = array(
        $data->id,
        $data->nombre,
        $data->presentacion,
        $data->gramaje,
        $data->cantidad_sala,
        $data->cantidad_actual,
        $data->abastecer,
        $data->opciones
    );
}
// crear un array con el array de los datos, importante que esten dentro de : data
$new_array  = array("data" => $data_array);
// crear el JSON apartir de los arrays
echo json_encode($new_array);
