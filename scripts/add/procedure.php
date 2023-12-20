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
  $clinica = $_POST['clinica'];
  $room = $_POST['sala'];
  $specialist = $_POST['especialista'];
  $procedure_date = $_POST['fecha_proced'];
  $notes = $_POST['observaciones'];

  $status = 1;
  if ($_SESSION['user_clinic'] == $clinica || $_SESSION['user_clinic'] == 5) {
    $sql = $conn->prepare("SELECT COUNT(*) FROM enf_patients WHERE num_med_record = ? AND clinic = ?; ");
    $sql->bind_param("is", $num_med_record, $clinica);

    $sql->execute();
    // Vincular resultado
    $sql->bind_result($count);
    $sql->fetch();
    $sql->close();
    if ($count <= 0) {
      $sql = $conn->prepare("INSERT INTO enf_patients (name, clinic, num_med_record, type, procedure_date, last_contact_date, status, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

      $sql->bind_param("ssisssii", $name, $clinica, $num_med_record, $type, $procedure_date, $procedure_date, $status, $created_by);

      if ($sql->execute() === TRUE) {

        $sql = $conn->prepare("INSERT INTO enf_procedures (clinic,num_med_record, name, type, room, specialist, procedure_date, notes, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        // Vincula los parámetros
        $sql->bind_param("iisiisssi", $clinica, $num_med_record, $name, $type, $room, $specialist, $procedure_date, $notes, $created_by);
        // Ejecuta la consulta
        if ($sql->execute() === TRUE) {
          $procedure_id = $conn->insert_id;

          $visits = array("Día 1", "Día 10", "Día 30", "Mes 3", "Mes 6", "Mes 9", "Mes 12", "Mes 18");
          $visit_date = NULL;
          $comments = '';
          $notes = '';
          foreach ($visits as $visit_type) {
            $sql2 = $conn->prepare("INSERT INTO enf_patient_visit_history (patient_id,visit_type,visit_date,comments,notes) VALUES (?, ?, ?, ?, ?)");
            $sql2->bind_param("issss", $procedure_id, $visit_type, $visit_date, $comments, $notes);

            // Continuar con la ejecución de $sql2
            if ($sql2->execute() !== TRUE) {
              $sql_executed = false;
            }
          }

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
        }
      } else {
        echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta ' . $sql->error]);
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'El número de expediente ya ha sido registrado. Verifica']);
    }
  } else {
    echo json_encode(['success' => false, 'message' => 'No tienes permisos para modificar esta clínica.']);
  }
}
