<?php
session_start();

require_once '../connection_db.php';

$data_array = array();
$procedure_id = $_POST['procedure_id'];

$sql = "SELECT eus.id, eus.supply_id, eus.quantity, eus.notes, es.name FROM enf_used_supplies eus LEFT JOIN enf_supplies es ON eus.supply_id = es.id WHERE eus.procedure_id = $procedure_id ORDER BY id DESC;";

$query = $conn->query($sql);

if (mysqli_num_rows($query) > 0) {
    while ($data = $query->fetch_object()) {
        $data_array[] = array(
            $data->id,
            $data->supply_id,
            $data->name,
            $data->quantity,
            $data->notes
        );
    }
}

$new_array  = array("data" => $data_array);
// crear el JSON apartir de los arrays
echo json_encode($new_array);
