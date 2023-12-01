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
  <link rel="icon" type="image/x-icon" href="favicon.png">

  <link rel="stylesheet" href="assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css" />

  <link rel="stylesheet" href="./assets/compiled/css/app.css" />
  <link rel="stylesheet" href="./assets/compiled/css/app-dark.css" />
  <link rel="stylesheet" href="./assets/extensions/font-awesome/css/font-awesome.css" />

  <link href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet" />
  <style>
    .card-body {
      color: var(--bs-body-color);
    }

    .counter {
      width: 70px;
      border-radius: 0px !important;
      text-align: center;
      background: transparent;
      border: none;
      color: var(--bs-body-color);
    }

    .up_count {
      margin-left: -4px;
      border-top-left-radius: 0px;
      border-bottom-left-radius: 0px;
    }

    .down_count {
      margin-right: -4px;
      border-top-right-radius: 0px;
      border-bottom-right-radius: 0px;
    }

    .dataTables_length {
      display: none !important;
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
            <div class="col-12 col-md-9 order-md-1 order-last">
              <h5>Medicamentos suministrados al paciente.</h5>
              <div class="card">
                <div class="card-body bg-dark">
                  <?php
                  $proced_id = $_GET['id'];
                  $sql = "SELECT * FROM enf_procedures WHERE id = $proced_id;";
                  $query = mysqli_query($conn, $sql);
                  $row = mysqli_fetch_assoc($query);

                  $tipo_injerto = ($row['type'] == 1) ? 'Capilar' : 'Barba';
                  $date = strtotime($row['procedure_date']);

                  echo "<h4><strong>PX: </strong>" . $row['name'] . "<br/></h4>";
                  echo "<strong>Fecha de Procedimiento: </strong>" . date("d/m/Y", $date) . "<br />";
                  echo "<strong>Realizando Injerto " . $tipo_injerto . " en Sala " . $row['room'] . "<br />";
                  ?>
                </div>
              </div>
            </div>
          </div>
          <table class="table table-striped table-hover" id="tabla_medicamentos">
            <thead>
              <tr>
                <th scope="col">Fármaco</th>
                <th scope="col">Cantidad</th>
              </tr>
            </thead>
            <tbody>
              <tr>
              </tr>
            </tbody>
          </table>
          <button class="btn btn-lg btn-block btn-success" id="enviarMed">Registrar uso de fármacos</button>
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
  <script src="assets/static/js/initTheme.js"></script>
  <script src="assets/extensions/jquery/jquery.min.js"></script>
  <script src="assets/static/js/components/dark.js"></script>
  <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="assets/compiled/js/app.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      var table = $("#tabla_medicamentos").DataTable({
        ajax: 'scripts/ajax-med-para-registros.php?id=<?= $_GET['id']; ?>',
        language: {
          url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
        },
        pageLength: -1,
        lengthMenu: [
          [-1],
          ['Todos']
        ],
        info: false, // Desactiva el mensaje "Mostrando X a Y de Z registros"
        paging: false, // Desactiva la paginación
      });

      $('.counter').click(function() {
        $(this).focus().select();
      });

      $("#enviarMed").click(function() {
        let proced_id = <?= $_GET['id']; ?>;

        var map = {};
        $(".counter").each(function() {
          map[$(this).attr("id")] = $(this).val();
        });


        $.ajax({
          type: "POST",
          url: 'scripts/subir_farmacos_proced.php',
          data: {
            map: map,
            proced_id: proced_id
          },
          beforeSend: function() {
            // setting a timeout
            $("body").css('filter', 'blur(4px)');
          },
          success: function() {
            setTimeout(() => {
              $("#alertupdate").css('display', 'block');
              $("body").css('filter', 'blur(0px)');
              $(window).scrollTop(0);

            }, 600);

          }
        });
      });
    });
    $(document).on("click", ".down_count", function() {
      let id_med = $(this).data("idmed");

      let input_val = $("#input-" + id_med).val();
      input_val = parseInt(input_val);

      if (input_val > 0)
        input_val = input_val - 1;

      $("#input-" + id_med).val(input_val);

    });
    $(document).on("click", ".up_count", function() {
      let id_med = $(this).data("idmed");

      let input_val = $("#input-" + id_med).val();
      input_val = parseInt(input_val);
      input_val = input_val + 1;

      $("#input-" + id_med).val(input_val);
    });
  </script>
</body>

</html>