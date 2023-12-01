<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.

session_start();
require_once "../connection_db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $success = true;

  $created_by = $_SESSION['user_id'];
  $num_med_record = ltrim($_POST['num_expediente'], 0);
  $name = $_POST['nombre_paciente'];
  $type = $_POST['tipo_injerto'];
  $room = $_POST['sala'];
  $specialist = $_POST['especialista'];
  $procedure_date = $_POST['fecha_proced'];
  $notes = $_POST['observaciones'];

  $sql = $conn->prepare("INSERT IGNORE INTO enf_procedures (num_med_record, name, type, room, specialist, procedure_date, notes, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  // Vincula los parámetros
  $sql->bind_param("isiisssi", $num_med_record, $name, $type, $room, $specialist, $procedure_date, $notes, $created_by);

  // Ejecuta la consulta
  if ($sql->execute() === TRUE) {
    $affected_rows = $sql->affected_rows;
    if ($affected_rows > 0) {
      $procedure_id = $conn->insert_id;
      $quantity = 0;

      $sql = "SELECT * FROM enf_medicines;";
      $query = $conn->query($sql);

      while ($row = $query->fetch_assoc()) {
        $medicine_id = $row['id'];
        $sql2 = $conn->prepare("INSERT INTO enf_used_medicines (medicine_id, procedure_id, quantity, date, updated_by) VALUES (?, ?, ?, ?, ?);");
        $sql2->bind_param("iiisi", $medicine_id, $procedure_id, $quantity, $procedure_date, $created_by);
        if ($sql2->execute() === TRUE) {
          $success = true;
        } else {
          $success = false;
        }
      }

      if ($success) {
        echo json_encode([
          'success' => $success,
          'message' => 'Datos insertados correctamente',
          'procedId' => $procedure_id
        ]);
      } else {
        echo json_encode([
          'success' => $success,
          'message' => 'Ocurrió un error.'
        ]);
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Error. El número de expediente ya ha sido registrado.']);
    }
  } else {
    echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta ' . $sql->error]);
  }
}
