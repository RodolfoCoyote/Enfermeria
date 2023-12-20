<?php
session_start();

require_once '../connection_db.php';

$data_array = array();
$procedure_id = $_GET['procedure_id'];

$sql = "SELECT * FROM enf_used_medicines WHERE procedure_id = $procedure_id;";

$query = $conn->query($sql);

if (mysqli_num_rows($query) > 0) {
    while ($data = $query->fetch_object()) {
        $data_array[] = array(
            $data->name,
            $data->options
        );
    }
}

$new_array  = array("data" => $data_array);
// crear el JSON apartir de los arrays
echo json_encode($new_array);
