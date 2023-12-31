<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // TS
header('Content-Type: application/json');


require_once '../connection_db.php';

$data_array = array();
// SQL para obtener los datos-
$sql = "SELECT id,num_med_record,name,type,room,specialist,DATE_FORMAT(procedure_date, '%d/%m/%Y') procedure_date,notes,created_by FROM enf_procedures;";
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

	$link_name = '<a data-procedureid="' . $data->id . '" data-proc_record="' . $data->num_med_record . '" data-name="' . $data->name . '" href="#" type="button" class="single_procedure">' . $data->name . '</a>';

	$data_array[] = array(
		$data->procedure_date,
		$data->num_med_record,
		$link_name,
		$type,
		$data->room,
		$data->specialist,
		$data->notes
	);
}
// crear un array con el array de los datos, importante que esten dentro de : data
$new_array  = array("data" => $data_array);
// crear el JSON apartir de los arrays
echo json_encode($new_array);
