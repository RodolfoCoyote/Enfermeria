<?php
session_start();
require_once "scripts/connection_db.php";

if (!isset($_SESSION['user_name'])) {
  header('Location: login.php'); // Redirigir al formulario de inicio de sesión
  exit();
}

// Resto del contenido de la página aquí
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio | Enfermería | RDI</title>
  <!-- <link rel="icon" type="image/x-icon" href="favicon.png"> -->


  <link rel="stylesheet" href="./assets/compiled/css/app.css" />
  <link rel="stylesheet" href="./assets/compiled/css/app-dark.css" />
  <link rel="stylesheet" href="./assets/extensions/font-awesome/css/font-awesome.css" />
  <link rel="stylesheet" href="../Pruebas-Web-RDI/auto-complete-box/style.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/timedropper/1.0/timedropper.css'>
  <style>
    .card-body {
      color: var(--bs-body-color);
    }
  </style>
</head>

<body>
  <div id="app">
    <?php require_once "templates/sidebar.php" ?>
    <div id="main" class="layout-navbar navbar-fixed">
      <header>
        <nav class="navbar navbar-expand navbar-light navbar-top">
          <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
              <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ms-auto mb-lg-0">
                <li class="nav-item dropdown me-1">
                </li>
              </ul>
              <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <div class="user-menu d-flex">
                    <div class="user-name text-end me-3">
                      <h6 class="mb-0 text-gray-600"><?php echo $_SESSION['user_name']; ?></h6>
                      <p class="mb-0 text-sm text-gray-600">Administrador</p>
                    </div>
                    <div class="user-img d-flex align-items-center">
                      <div class="avatar avatar-md">
                        <img src="./assets/compiled/jpg/1.jpg" />
                      </div>
                    </div>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem">
                  <li>
                    <h6 class="dropdown-header">Hello, <?= $_SESSION['user_name']; ?></h6>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#"><i class="icon-mid bi bi-person me-2"></i>Mi Perfil</a>
                  </li>

                  <li>
                    <hr class="dropdown-divider" />
                  </li>
                  <li>
                    <a class="dropdown-item" href="logout.php">
                      <i class="icon-mid bi bi-box-arrow-left me-2"></i>Logout
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </nav>
      </header>
      <div id="main-content">
        <div class="page-heading">
          <div class="row">
            <div class="text-center col-12 col-xs-12 order-md-1 order-last mx-auto">
              <h5>Medicamentos suministrados al paciente.</h5>
              <div class="card">
                <div class="card-body">
                  <?php
                  $proced_id = $_GET['id'];
                  $sql = "SELECT * FROM enf_procedures WHERE id = $proced_id;";
                  $query = mysqli_query($conn, $sql);
                  $row = mysqli_fetch_assoc($query);

                  $tipo_injerto = ($row['type'] == 1) ? 'Capilar' : 'Barba';
                  $date = strtotime($row['procedure_date']);

                  switch ($row['clinic']) {
                    case 1:
                      $clinic_label = "CDMX";
                      break;
                    case 2:
                      $clinic_label = "Culiacán";
                      break;
                    case 3:
                      $clinic_label = "Mazatlán";
                      break;
                    case 4:
                      $clinic_label = "Tijuana";
                      break;
                    default:
                      $clinic_label = "Clínica no asignada";
                  }

                  echo "<h3 style='color:#e0ac44;' class='card-title'>{$row['name']}</h3>";
                  echo "<p><span style='font-size:20px;' class='badge bg-secondary'>#{$row['num_med_record']}</span></p>";
                  echo "<p><span style='font-size:20px;' class='badge bg-primary'>{$tipo_injerto}</span>";
                  echo "<span style='font-size:20px;' class='badge bg-light'>{$clinic_label}</span></p>";

                  echo "<p style='font-size:20px;'><strong>Sala: </strong>" . $row['room'] . "<br />";
                  echo "<strong>Especialista: </strong>" . $row['specialist'] . "<br />";
                  echo "<strong>Fecha Procedimiento: </strong>" . date("d/m/Y", $date) . "</p>";
                  ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-5 col-xs-12 mx-auto text-center">
              <h4>Medicamento suministrado</h4>
              <div class="container">
                <div class="search-bar">
                  <input id="inputTxt" type="text" placeholder="Buscar ...">
                </div>
                <div class="list-group" id="list-medicines" style="display:none;">
                </div>
              </div>
            </div>
          </div>
          <div class="container mt-4">
            <div class="row">
              <div class="col-12 col-md-5 mx-auto text-center">
                <h6>Medicamentos Anteriores</h6>
                <ul class=""> //list-group
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Alprazolam Tableta 30Mg
                    <span class="badge bg-primary">10</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer>
        <div class="footer clearfix mb-0 text-muted">
          <div class="float-start">
            <p>2023 &copy; Los Reyes del Injerto</p>
          </div>
          <div class="float-end">
            <p>
              Todos los derechos reservados
            </p>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <div class="modal fade text-left" id="medicineDataModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <form method="POST" id="formMedicineModal">
          <div class="modal-body">
            <div class="row">
              <div class="col-12">
                <input type="text" id="form_type" name="form_type">
                <input type="text" id="procedure_id" name="procedure_id" value="<?= $_GET['id']; ?>">
                <input type="text" id="medicine_id" name="medicine_id" value="">

                <div class="form-group">
                  <label for="hour">Hora en que se suministró:</label>
                  <input type="text" class="form-control" name="hour" id="hour" required>
                </div>
                <div class="form-group">
                  <label for="hour">Cantidad suministrada:</label>
                  <input type="number" class="form-control" name="qty" id="qty" required>
                </div>
                <div class="form-group">
                  <label for="hour">Comentarios:</label>
                  <textarea class="form-control" name="comments" id="comments" cols=3></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-sm-block">Cerrar</span>
            </button>
            <button type="submit" class="btn btn-success ms-1">
              <i class="bx bx-check d-block d-sm-none"></i>
              <span class="d-sm-block">Agregar</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

  <script src="assets/static/js/initTheme.js"></script>
  <script src="assets/static/js/components/dark.js"></script>
  <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="assets/compiled/js/app.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.js"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/timedropper/1.0/timedropper.js'></script>
  <script type="text/javascript">
    $(document).ready(function() {

      $("#hour").timeDropper({
        format: 'hh:mm A',
        meridians: true,
        setCurrentTime: true,
        primaryColor: "#e0ac44",
        borderColor: "#e0ac44",
      });

      let choices = [];

      $.ajax({
        method: 'POST',
        url: 'scripts/load/medicines.php',
        dataType: 'json'
      }).done(function(response) {

        $.each(response.data, function(index, value) {
          let medicine_id = value[0];
          let medicine_data = `${value[1]} ${value[2]} ${value[3]}`;
          choices.push([medicine_id, medicine_data]);

        });
        console.log(choices)
        let a = document;
        let list_group = a.querySelector(".list-group");

        function ListItemGenerator() {
          if (!inputTxt.value) {
            inputTxt.parentElement.classList.remove("active");
            list_group.style.display = "none";
          } else {
            inputTxt.parentElement.classList.add("active");
            list_group.style.display = "block";

            let SearchResults = choices.filter(function(choice) {
              return choice[1].toLowerCase().startsWith(inputTxt.value.toLowerCase());
            });

            CreatingList(SearchResults);

            function CreatingList(Words) {
              let createdList = Words.map(function(word) {
                return "<li data-medicineid='" + word[0] + "'>" + word[1] + "</li>";
              });
              let CustomListItem;
              if (!CreatingList.length) {
                CustomListItem = "<li>" + inputTxt.value + "</li>";
              } else {
                CustomListItem = createdList.join("");
              }
              list_group.innerHTML = CustomListItem;
              CompleteText();
            }
          }

          function CompleteText() {
            all_list_items = list_group.querySelectorAll("li");
            all_list_items.forEach(function(list) {
              list.addEventListener("click", function(e) {
                inputTxt.value = e.target.textContent;
                list_group.style.display = "none";
              });
            });
          }
        }

        inputTxt.addEventListener("keyup", ListItemGenerator);
      }).fail(function(response) {
        console.log(response);
      });

      $.ajax({
        method: 'POST',
        url: 'scripts/load/medicines_procedure.php',
        dataType: 'json'
      }).done(function(response) {

        $.each(response.data, function(index, value) {
          let medicine_id = value[0];
          let medicine_data = `${value[1]} ${value[2]} ${value[3]}`;
          choices.push([medicine_id, medicine_data]);

        });
        console.log(choices)
        let a = document;
        let list_group = a.querySelector(".list-group");

        function ListItemGenerator() {
          if (!inputTxt.value) {
            inputTxt.parentElement.classList.remove("active");
            list_group.style.display = "none";
          } else {
            inputTxt.parentElement.classList.add("active");
            list_group.style.display = "block";

            let SearchResults = choices.filter(function(choice) {
              return choice[1].toLowerCase().startsWith(inputTxt.value.toLowerCase());
            });

            CreatingList(SearchResults);

            function CreatingList(Words) {
              let createdList = Words.map(function(word) {
                return "<li data-medicineid='" + word[0] + "'>" + word[1] + "</li>";
              });
              let CustomListItem;
              if (!CreatingList.length) {
                CustomListItem = "<li>" + inputTxt.value + "</li>";
              } else {
                CustomListItem = createdList.join("");
              }
              list_group.innerHTML = CustomListItem;
              CompleteText();
            }
          }

          function CompleteText() {
            all_list_items = list_group.querySelectorAll("li");
            all_list_items.forEach(function(list) {
              list.addEventListener("click", function(e) {
                inputTxt.value = e.target.textContent;
                list_group.style.display = "none";
              });
            });
          }
        }

        inputTxt.addEventListener("keyup", ListItemGenerator);
      }).fail(function(response) {
        console.log(response);
      });

      $('#medicineDataModal').on('hidden.bs.modal', function(e) {
        // Código a ejecutar cuando la modal se cierra
        $("#inputTxt,#medicine_id").val('');
      });

      $("#formMedicineModal").submit(function(e) {
        e.preventDefault();
        let method = $(this).attr('method');
        let form_type = $("#form_type").val();
        let url = `scripts/${form_type}/medicine_procedure.php`;
        let formData = $(this).serialize();
        alert(url);

        $.ajax({
          method: method,
          url: url,
          data: formData,
          dataType: 'json'
        }).done(function(response) {
          if (response.success) {

            Swal.fire({
              title: 'Listo!',
              text: response.message,
              icon: 'success',
              timer: 2500, // Tiempo en milisegundos (en este caso, 3000 ms = 3 segundos)
              timerProgressBar: true, // Muestra una barra de progreso
              showConfirmButton: false
            }).then((result) => {
              location.reload();
            });
          } else {
            Swal.fire({
              title: 'Error',
              text: response.message,
              icon: 'error',
              timer: 2500, // Tiempo en milisegundos (en este caso, 3000 ms = 3 segundos)
              timerProgressBar: true, // Muestra una barra de progreso
              showConfirmButton: false // No muestra el botón de confirmación
            });
          }
        }).fail(function(response) {
          console.log(response);
          Swal.fire({
            title: 'Error',
            text: 'Contacta a administración',
            icon: 'error',
            timer: 2500, // Tiempo en milisegundos (en este caso, 3000 ms = 3 segundos)
            timerProgressBar: true, // Muestra una barra de progreso
            showConfirmButton: false // No muestra el botón de confirmación
          });
        });
      });
    });


    $(document).on("click", "#list-medicines li", function() {
      let medicine_id = $(this).data('medicineid');

      $("#medicine_id").val(medicine_id);
      $("#form_type").val("add");
      $("#medicineDataModal").modal("show");
    });
  </script>
</body>

</html>