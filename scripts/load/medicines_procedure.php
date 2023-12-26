<?php
session_start();

require_once '../connection_db.php';

$data_array = array();
$procedure_id = $_POST['procedure_id'];

$sql = "SELECT eum.id, eum.medicine_id,eum.quantity, DATE_FORMAT(eum.time, '%h:%i %p') time, eum.comments, em.name FROM enf_used_medicines eum LEFT JOIN enf_medicines em ON eum.medicine_id = em.id WHERE eum.procedure_id = $procedure_id ORDER BY eum.time DESC;";

$query = $conn->query($sql);

if (mysqli_num_rows($query) > 0) {
    while ($data = $query->fetch_object()) {
        $data_array[] = array(
            $data->id,
            $data->quantity,
            $data->time,
            $data->comments,
            $data->name,
            $data->medicine_id
        );
    }
}

$new_array  = array("data" => $data_array);
// crear el JSON apartir de los arrays
echo json_encode($new_array);
