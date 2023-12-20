<?php
require_once "../connection_db.php";

$procedure_id = $_POST['procedure_id'];

$sql = "SELECT id, clinic, num_med_record, name, type, room, specialist,procedure_date, notes, created_by FROM enf_procedures WHERE id=$procedure_id;";

$query = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($query);
echo json_encode($row);
