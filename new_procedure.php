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
  <title>Inicio | Enfermería | RDI</title>

  <link rel="shortcut icon" href="../1/assets/img/favicon.png" type="image/x-icon" />
  <link rel="stylesheet" href="assets/compiled/css/app.css" />
  <link rel="stylesheet" href="assets/compiled/css/app-dark.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">
  <style>
    .swal2-popup {
      border-radius: 10px;
      background-color: #fff;
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
    }

    .swal2-title {
      font-size: 1.5em;
      color: #333;
    }

    .swal2-text {
      color: #555;
    }

    .swal2-confirm,
    .swal2-cancel {
      padding: 0.5em 1em;
      font-size: 1em;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
    }

    .swal2-confirm {
      background-color: #d33;
      color: #fff;
      margin-left: 0.5em;
    }

    .swal2-cancel {
      background-color: #3085d6;
      color: #fff;
    }

    .form-label {
      color: #e0ac44 !important;
      font-weight: bold !important;
    }
  </style>
</head>

<body>
  <div id="app">
    <?php require_once("templates/sidebar.php"); ?>
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
                      <i class="icon-mid bi bi-box-arrow-left me-2"></i>Cerrar sesión
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
          <div class="page-title">
            <div class="row">
              <div class="col-12 col-md-6 text-center">
                <h3>Agregar nuevo procedimiento</h3>
                <p class="text-subtitle text-muted">
                </p>
              </div>
            </div>
          </div>
          <section class="section">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"></h4>
              </div>
              <div class="card-body">
                <section class="section">
                  <div class="row">
                    <form method="POST" id="formNuevoProced" action="#">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label" for="basicInput">Nombre del Paciente</label>
                          <input type="text" class="form-control" name="nombre_paciente" id="nombre_paciente" placeholder="" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label class="form-label" for="basicInput">Número de Expediente</label>
                            <input type="number" class="form-control" name="num_expediente" id="num_expediente" placeholder="" required>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label class="form-label" for="basicInput">Clínica:</label>
                            <select class="form-control" id="clinica" name="clinica" required>
                              <option value=0 selected disabled readonly>Selecciona</option>
                              <option data-clinicesp="cdmx" data-clinicname="CDMX" value=1>CDMX</option>
                              <option data-clinicesp="cul" data-clinicname="Culiacán" value=2>Culiacán</option>
                              <option data-clinicesp="mzt" data-clinicname="Mazatlán" value=3>Mazatlán</option>
                              <option data-clinicesp="tj" data-clinicname="Tijuana" value=4>Tijuana</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label class="form-label" for="basicInput">Tipo de Injerto</label>
                            <select class="form-control" id="tipo_injerto" name="tipo_injerto" required>
                              <option value=0 selected disabled readonly>Selecciona</option>
                              <option value=1>Capilar</option>
                              <option value=2>Barba</option>
                              <option value=3>Ambos</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label class="form-label" for="basicInput">Sala utilizada:</label>
                            <select class="form-control" id="sala" name="sala" required>
                              <option value=0 selected disabled readonly>Selecciona</option>
                              <option value=1>1</option>
                              <option value=2>2</option>
                              <option value=3>3</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label class="form-label" for="basicInput">Especialista responsable:</label>
                            <select class="form-control" id="especialista" name="especialista" required>

                            </select>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label class="form-label" sfor="basicInput">Fecha del Procedimiento:</label>
                            <input type="date" class="form-control" name="fecha_proced" id="fecha_proced" placeholder="" required>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="form-label" for="basicInput">Observaciones</label>
                        <textarea type="date" class="form-control" name="observaciones" id="observaciones" rows=3></textarea>
                      </div>
                      <input id="btnAddProc" type="submit" class="btn btn-primary btn-block me-1 mb-1" />
                    </form>
                  </div>
                </section>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>

  <?php require_once("templates/footer.php"); ?>

  <script src="assets/static/js/pages/jquery.js"></script>
  <script src="assets/static/js/initTheme.js"></script>
  <script src="assets/static/js/components/dark.js"></script>
  <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="assets/compiled/js/app.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#formNuevoProced").submit(function(e) {
        e.preventDefault();

        let datosProced = $(this).serialize();

        $.ajax({
          method: 'POST',
          url: 'scripts/add/procedure.php',
          data: datosProced,
          dataType: 'json'
        }).done(function(response) {
          if (response.success) {
            let procedId = response.procedId;

            Swal.fire({
              title: 'Listo!',
              text: 'Procedimiento registrado...',
              icon: 'success',
              timer: 2500, // Tiempo en milisegundos (en este caso, 3000 ms = 3 segundos)
              timerProgressBar: true, // Muestra una barra de progreso
              showConfirmButton: false
            }).then((result) => {
              window.location.href = 'view_procedures.php?id=' + procedId;
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
      $("#clinica").change(function() {
        let clinic_selected = $(this).find('option:selected').data('clinicesp');
        let especialistas = [{
            valor: 'Dr. Alejandro Santana',
            texto: 'Dr. Alejandro Santana',
            clinic: 'Todas'
          },
          {
            valor: 'Luis Moreno',
            texto: 'Luis Moreno',
            clinic: 'cdmx'
          },
          {
            valor: 'Xóchitl Lagunas',
            texto: 'Xóchitl Lagunas',
            clinic: 'cdmx'
          },
          {
            valor: 'Héctor Carmona',
            texto: 'Héctor Carmona',
            clinic: 'cdmx'
          },
          {
            valor: 'Antonio',
            texto: 'Antonio',
            clinic: 'cul'
          },
          {
            valor: 'Laura',
            texto: 'Laura',
            clinic: 'cul'
          },
          {
            valor: 'Dra. Fernanda',
            texto: 'Dra. Fernanda',
            clinic: 'cul'
          }, {
            valor: 'Itzel',
            texto: 'Itzel',
            clinic: 'mzt'
          }, {
            valor: 'Belén',
            texto: 'Belén',
            clinic: 'tj'
          }
        ];

        // Vaciar el select
        $('#especialista').empty();

        $('#especialista').append($('<option>', {
          value: 'Dr. Alejandro Santana',
          text: 'Dr. Alejandro Santana'
        }));
        // Añadir cada nueva opción al select
        $.each(especialistas, function(i, opcion) {
          if (clinic_selected == opcion.clinic) {
            $('#especialista').append($('<option>', {
              value: opcion.valor,
              text: opcion.texto
            }));
          }
        });
      });
    });
  </script>
</body>

</html>