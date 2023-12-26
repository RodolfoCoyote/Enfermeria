<?php
session_start();

if (!isset($_SESSION['user_name'])) {
  header('Location: login.php'); // Redirigir al formulario de inicio de sesión
  exit();
}

// Resto del contenido de la página aquí
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Procedimientos | Enfermería RDI</title>

  <link rel="icon" type="image/x-icon" href="favicon.png">
  <link rel="stylesheet" href="./assets/compiled/css/app.css" />
  <link rel="stylesheet" href="./assets/compiled/css/app-dark.css" />
  <link rel="stylesheet" href="./assets/extensions/font-awesome/css/font-awesome.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

  <style>
    #table1 thead tr th {
      text-align: center !important;
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
                      <h6 class="mb-0 text-gray-600"><?php echo $_SESSION['name']; ?></h6>
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
                    <h6 class="dropdown-header">Hello, <?= $_SESSION['name']; ?></h6>
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
        <h3>Lista de procedimientos</h3>
        <!-- Basic Tables start -->
        <div class="card-body">

          <div class="table-responsive">
            <table class="table table-striped" id="table1">
              <thead>
                <tr>
                  <th>Fecha Proc.</th>
                  <th>Exp. No.</th>
                  <th>Paciente</th>
                  <th>Injerto</th>
                  <th>Sala</th>
                  <th>Especialista</th>
                  <th>Observaciones</th>
                </tr>
              </thead>
            </table>
          </div>
        </div> <!-- Basic Tables end -->
      </div>

      <?php require_once "templates/footer.php" ?>
    </div>
  </div>
  <div class="modal fade" id="optionsModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Opciones</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <button class="btn-options btn-1 btn-sep icon-info" data-method="info" id="btnInfo">Información</button>
            <button class="btn-options btn-2 btn-sep icon-pills" data-method="med" id="btnMed">Insumos</button>
            <button class="btn-options btn-3 btn-sep icon-photo" data-method="photo" id="btnPhoto">Fotografías</button>
            <button class="btn-options btn-4 btn-sep icon-rev" data-method="photo" id="btnRev">Revisiones</button>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="inlineForm" tabindex="-1" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Editar Procedimiento.
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form action="scripts/update/procedure.php" method="POST" id="formUpdateProcedure">
            <input id="id_p" name="id_p" type="hidden" placeholder="Número de Expediente" class="form-control" />
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="num_expediente">Núm. de Expediente</label>
                  <input id="num_expediente" name="num_expediente" type="text" placeholder="Número de Expediente" class="form-control" readonly />
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="clinic">Clínica</label>
                  <input id="clinic" name="clinic" type="text" placeholder="Clínica" class="form-control" readonly />
                </div>
              </div>
            </div>
            <label for="nombre">Nombre del paciente</label>
            <div class="form-group">
              <input id="nombre_paciente" name="nombre_paciente" type="Nombre del fármaco" placeholder="Nombre del Paciente" class="form-control" />
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="basicInput">Tipo de Injerto</label>
                  <select class="form-control" id="tipo_injerto" name="tipo_injerto" required>
                    <option value=0 disabled readonly>Selecciona</option>
                    <option value=1>Capilar</option>
                    <option value=2>Barba</option>
                    <option value=3>Ambos</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="gramaje">Sala</label>
                  <select class="form-control" id="sala" name="sala" required>
                    <option value=0 disabled readonly>Selecciona</option>
                    <option value=1>1</option>
                    <option value=2>2</option>
                    <option value=3>3</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="gramaje">Especialista</label>
              <select class="form-control" id="especialista" name="especialista" required>
              </select>
            </div>
            <div class="form-group">
              <label>Observaciones</label>
              <textarea id="observaciones" name="observaciones" placeholder="" class="form-control" rows=4></textarea>
            </div>
            <label for="cantidad_sala">Fecha de procedimiento</label>
            <div class="form-group">
              <input id="fecha_proced" name="fecha_proced" type="date" placeholder="" class="form-control" />
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-sm-block">Cerrar</span>
          </button>
          <button type="submit" class="btn btn-success ms-1">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-sm-block">Actualizar</span>
          </button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <script src="assets/static/js/initTheme.js"></script>
  <script src="assets/static/js/components/dark.js"></script>
  <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="assets/compiled/js/app.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.10.25/sorting/datetime-moment.js"></script>

  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function() {
      /* =============== DATATABLE Start =============== */
      DataTable.datetime('DD/MM/YYYY');

      let jquery_datatable = $("#table1").DataTable({
        ajax: 'scripts/load/procedures.php',
        autoWidth: false,
        language: {
          url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
        },
        scrollX: true,
        order: [
          [0, 'desc']
        ] // Asume que la columna 0 es donde están tus fechas
      });
      const setTableColor = () => {
        document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
          dt.classList.add('pagination-primary')
        })
      }
      setTableColor()
      jquery_datatable.on('draw', setTableColor)
      /* =============== DATATABLE End =============== */

      $(document).on("click", ".single_procedure", function(e) {
        e.preventDefault()
        let procedure_id = $(this).data('procedureid');
        $("#btnInfo,#btnMed,#btnPhoto,#btnRev").data('procedureid', procedure_id);
        $("#optionsModal").modal("show");
      });

      $("#formUpdateProcedure").submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        let method = $(this).attr('method');
        let url = $(this).attr('action');
        console.log(formData);
        $.ajax({
          method: method,
          url: url,
          data: formData,
          dataType: 'json'
        }).done(function(response) {
          if (response.success) {

            Swal.fire({
              title: 'Listo!',
              text: 'Procedimiento actualizado...',
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
        });
      });
    });


    $(document).on("click", "#btnInfo", function() {
      $("#optionsModal").modal("hide");
      let procedure_id = $(this).data('procedureid');

      $.ajax({
        type: "POST",
        url: 'scripts/load/single_procedure.php',
        data: {
          procedure_id: procedure_id
        },
        dataType: 'json',
        success: function(data) {
          let especialistas = [{
              valor: 'Luis Moreno',
              texto: 'Luis Moreno',
              clinic: 1
            },
            {
              valor: 'Xóchitl Lagunas',
              texto: 'Xóchitl Lagunas',
              clinic: 1
            },
            {
              valor: 'Héctor Carmona',
              texto: 'Héctor Carmona',
              clinic: 1
            },
            {
              valor: 'Dra. Fernanda Bojorquez',
              texto: 'Dra. Fernanda Bojorquez',
              clinic: 2
            },
            {
              valor: 'Antonio Pérez',
              texto: 'Antonio Pérez',
              clinic: 2
            },
            {
              valor: 'Javier Romo',
              texto: 'Javier Romo',
              clinic: 2
            },
            {
              valor: 'Laura Herrera',
              texto: 'Laura Herrera',
              clinic: 2
            },
            {
              valor: 'Dra. Oriana Aguilar',
              texto: 'Dra. Oriana Aguilar',
              clinic: 3
            },
            {
              valor: 'Itzel Rodríguez',
              texto: 'Itzel Rodríguez',
              clinic: 3
            },
            {
              valor: 'Belén',
              texto: 'Belén',
              clinic: 4
            }
          ];

          let clinics = ["CDMX", "Culiacán", "Mazatlán", "Tijuana"];

          $("#id_p").val(data.id);
          $("#num_expediente").val(data.num_med_record);
          $("#clinic").val(clinics[data.clinic - 1]);
          $("#nombre_paciente").val(data.name);
          $("#tipo_injerto").val(data.type);
          $("#sala").val(data.room);
          $("#observaciones").val(data.notes);
          $("#fecha_proced").val(data.procedure_date);

          // Vaciar el select
          $('#especialista').empty();

          $('#especialista').append($('<option>', {
            value: 'Dr. Alejandro Santana',
            text: 'Dr. Alejandro Santana'
          }));
          // Añadir cada nueva opción al select
          $.each(especialistas, function(i, opcion) {
            if (data.clinic == opcion.clinic) {
              $('#especialista').append($('<option>', {
                value: opcion.valor,
                text: opcion.texto
              }));
            }
          });
          $("#especialista").val(data.specialist);
        }
      });
      $('#inlineForm').modal('show');
    });
    $(document).on("click", "#btnMed", function() {
      const procedure_id = $(this).data('procedureid');
      window.location.href = "procedure_medicines.php?id=" + procedure_id;
    });
    $(document).on("click", "#btnPhoto", function() {
      let procedure_id = $(this).data('procedureid');
      window.location.href = "procedure_photos.php?id=" + procedure_id;

    });
    $(document).on("click", "#btnRev", function() {
      const procedure_id = $(this).data('procedureid');
      window.location.href = "mod_revisiones/index.php?id=" + procedure_id;
    });
  </script>
</body>

</html>