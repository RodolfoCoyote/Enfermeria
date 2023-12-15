<?php

$con = new mysqli("localhost", "root", "", "losreyesdelinjerto_com");
//$con = new mysqli("mysql.losreyesdelinjerto.com","losreyesdelinjer","BxJ9g2GC","losreyesdelinjerto_com");

$data_array = array();
$proced_id = $_GET['id'];

$sql = "SELECT * FROM enf_used_medicines WHERE procedure_id = $proced_id;";
$query = mysqli_query($con, $sql);
if (mysqli_num_rows($query) > 0) {

    $sql = "SELECT CONCAT(name,\" \",presentation,\" \",dosage) as name, CONCAT(\"
    <div class='main text-center'>
        <button class='button_counters down_count btn btn-sm btn-dark' data-idmed='\",med.id,\"' title='Down'>
            <i class='bi bi-dash-lg'></i>
        </button>
        <input class='counter' id='input-\",med.id,\"' type='text' value='\",used.quantity,\"' name='input'/>
        <button class='button_counters up_count btn btn-sm btn-dark' data-idmed='\",med.id,\"' title='Up'>
            <i class='bi bi-plus-lg'></i>
        </button>
    </div>\") as options FROM enf_medicines med INNER JOIN enf_used_medicines used ON med.id = used.medicine_id WHERE used.procedure_id = $proced_id;";
}

$query = $con->query($sql);
while ($data = $query->fetch_object()) {

    $data_array[] = array(
        $data->name,
        $data->options
    );
}
$new_array  = array("data" => $data_array);
// crear el JSON apartir de los arrays
echo json_encode($new_array);
