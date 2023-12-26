<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // TS
header('Content-Type: application/json');

session_start();
require_once '../connection_db.php';

$data_array = array();
$user_clinic = $_SESSION['user_clinic'];
// SQL para obtener los datos
$sql = "SELECT id, clinic, num_med_record,name,type,room,specialist,DATE_FORMAT(procedure_date, '%d/%m/%Y') procedure_date,SUBSTRING(notes, 1, 100) notes,created_by FROM enf_procedures WHERE clinic = $user_clinic;";

if ($user_clinic == 5) {
	$sql = "SELECT id, clinic, num_med_record,name,type,room,specialist,DATE_FORMAT(procedure_date, '%d/%m/%Y') procedure_date,SUBSTRING(notes, 1, 100) notes,created_by FROM enf_procedures;";
}

// Ejeuctar el SQL
$query = $conn->query($sql);
// Recorrer los resultados
while ($data = $query->fetch_object()) {
	switch ($data->type) {
		case 1:
			$type = 'Capilar';
			break;
		case 2:
			$type = 'Barba';
			break;
		case 3:
			$type = 'Ambos';
			break;
		default:
			$type = 'Desconocido';
			break;
	}

	if ($user_clinic == 5) {
		switch ($data->clinic) {
			case 1:
				$prefix_num_med_r = 'CD-';
				break;
			case 2:
				$prefix_num_med_r = 'CU-';
				break;
			case 3:
				$prefix_num_med_r = 'M-';
				break;
			case 4:
				$prefix_num_med_r = 'T-';
				break;
		}

		$num_med_record = $prefix_num_med_r . $data->num_med_record;
	} else {
		$num_med_record = $data->num_med_record;
	}

	$link_name = '<a data-procedureid="' . $data->id . '" data-proc_record="' . $data->num_med_record . '" data-name="' . $data->name . '" href="#" type="button" class="single_procedure">' . $data->name . '</a>';

	$notes = $data->notes . "...";
	$data_array[] = array(
		$data->procedure_date,
		$num_med_record,
		$link_name,
		$type,
		$data->room,
		$data->specialist,
		$notes
	);
}
// crear un array con el array de los datos, importante que esten dentro de : data
$new_array  = array("data" => $data_array);
// crear el JSON apartir de los arrays
echo json_encode($new_array);
