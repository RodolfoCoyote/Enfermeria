<?php
session_start();
require_once "scripts/connection_db.php";

if (!isset($_SESSION['user_name'])) {
  header('Location: login.php'); // Redirigir al formulario de inicio de sesión
  exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio | Enfermería | RDI</title>

  <link rel="shortcut icon" href="../1/assets/img/favicon.png" type="image/x-icon" />

  <link rel="stylesheet" href="assets/compiled/css/app.css" />
  <link rel="stylesheet" href="assets/compiled/css/app-dark.css" />


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
  <link href="assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />

  <link rel=" stylesheet" href="assets/css/slick.css">
  <link rel="stylesheet" href="assets/css/style.css">

  <style>
    .paciente_info {
      font-size: 17px;
    }

    .carousel-image {
      max-height: 250px;
      width: auto;
      display: block;
      margin-left: auto;
      margin-right: auto;
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
                <li class="nav-item dropdown me-1">¡
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


          <!-- left part 1st section  -->

          <!--  <div class="section-header">
            <div class="slick-arrows-top">
                <buttton class="carousel-topNav-prev slick-custom-buttons" type="button"
                    data-role="none" aria-label="Previous">
                    <i class="icon-arrow-left"></i>
                </buttton>
                <buttton class="carousel-topNav-next slick-custom-buttons" type="button"
                    data-role="none" aria-label="Next">
                    <i class="icon-arrow-right"></i>
                </buttton>
            </div>
        </div> -->

          <div class="row">
            <div class="text-center col-md-12 col-xs-12 order-md-1 order-last">
              <h3 class="text-center">Evolución de paciente.</h3>
              <!-- <a type="button" class="btn btn-warning" href="comparar_fotos2.php?id=6">Version 2.0</a> -->
              <div class="offset-md-3 col-md-6 col-xs-12">
                <div class="card">
                  <div class="card-body">
                    <?php
                    $proced_id = $_GET['id'];
                    $sql = "SELECT * FROM enf_procedures WHERE id = $proced_id;";
                    $query = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($query);

                    $tipo_injerto = ($row['type'] == 1) ? 'Capilar' : 'Barba';
                    $date = strtotime($row['procedure_date']);
                    echo "<h3 style='color:#e0ac44;' class='card-title'>{$row['name']}</h3>";
                    echo "<p><span style='font-size:20px;' class='badge bg-secondary'>#{$row['num_med_record']}</span>";
                    echo "<span style='font-size:20px;' class='badge bg-primary'>{$tipo_injerto}</span></p>";

                    echo "<p style='font-size:20px;'><strong>Sala: </strong>" . $row['room'] . "<br />";
                    echo "<strong>Especialista: </strong>" . $row['specialist'] . "<br />";
                    echo "<strong>Fecha Procedimiento: </strong>" . date("d/m/Y", $date) . "</p>";
                    ?>
                  </div>
                  <input type="hidden" id="num_med_record" name="num_med_record" value="<?= $row['num_med_record'] ?>">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <h3 style="text-align:center;">Selecciona la etapa:</h3>
            <div class="col-6">
              <select class="form-control" id="first-side">
                <option data-side=1 value=0 selected disabled>Selecciona</option>
                <option data-side=1 value="pre">Pre-procedimiento</option>
                <option data-side=1 value="diseno">Diseño</option>
                <option data-side=1 value="post">Post-procedimiento</option>
                <option data-side=1 value="24horas">24 Horas</option>
                <option data-side=1 value="10dias">10 Días</option>
                <option data-side=1 value="1mes">1 Mes</option>
                <option data-side=1 value="3meses">3 Meses</option>
                <option data-side=1 value="6meses">6 Meses</option>
                <option data-side=1 value="9meses">9 Meses</option>
                <option data-side=1 value="12meses">12 Meses</option>
                <option data-side=1 value="18meses">18 Meses</option>
              </select>
            </div>
            <div class="col-6">
              <select class="form-control" id="second-side">
                <option data-side=2 value=0 selected disabled>Selecciona</option>
                <option data-side=2 value="pre">Pre-procedimiento</option>
                <option data-side=2 value="diseno">Diseño</option>
                <option data-side=2 value="post">Post-procedimiento</option>
                <option data-side=2 value="24horas">24 Horas</option>
                <option data-side=2 value="10dias">10 Días</option>
                <option data-side=2 value="1mes">1 Mes</option>
                <option data-side=2 value="3meses">3 Meses</option>
                <option data-side=2 value="6meses">6 Meses</option>
                <option data-side=2 value="9meses">9 Meses</option>
                <option data-side=2 value="12meses">12 Meses</option>
                <option data-side=2 value="18meses">18 Meses</option>
              </select>
            </div>
          </div>
          <div class="row" id="comparador">
            <div class="col-6">
              <div class="row" style="margin-bottom:20px;margin-top:20px;" id="thumbs-side-1"></div>
              <img id="img1" src="" class="img-fluid mx-auto">
            </div>
            <div class="col-6">
              <div class="row" style="margin-bottom:20px;margin-top:20px;" id="thumbs-side-2"></div>
              <img id="img2" src="" class="img-fluid mx-auto">
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
  <script src="assets/static/js/initTheme.js"></script>
  <script src="assets/static/js/components/dark.js"></script>
  <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="assets/compiled/js/app.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

  <script src="assets/js/slick.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function() {
      $("#first-side,#second-side").change(function() {

        let num_med_record = <?= $row['num_med_record']; ?>;
        let step = $(this).val();
        let side = $(this).find('option:selected').data('side');
        let image = $("#img" + side);
        image.attr('src', '');

        Swal.fire({
          title: "Cargando...",
          allowOutsideClick: false,
          showConfirmButton: false,
        });

        $.ajax({
            data: {
              num_med_record: num_med_record,
              step: step,
              side: side
            },
            method: "POST",
            url: "test.php",
          })
          .done(function(thumbs) {
            $("#thumbs-side-" + side).html(thumbs);

            $(".post-carousel-twoCol-" + side).slick({
              dots: false,
              arrows: false,
              slidesToShow: 3,
              slidesToSCroll: 1,
              responsive: [{
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 2,
                    slidesToSCroll: 2,
                    dots: false,
                    arrows: false,
                  }
                },
                {
                  breakpoint: 576,
                  settings: {
                    slidesToShow: 1,
                    slidesToSCroll: 1,
                    dots: false,
                    arrows: false,
                  }
                }
              ]
            });
          })
          .fail(function(response) {
            console.log(response);
          }).always(function() {
            Swal.close();
          });
      });
    });
    $(document).on("mouseover", ".carousel-image", function() {
      $(this).css('cursor', 'pointer');
    });
    $(document).on("click", ".carousel-image", function() {
      var src = $(this).data('zoom');
      var side = $(this).data('side');
      var image = $("#img" + side);

      image.fadeOut('fast', function() {
        image.attr('src', src);
        image.fadeIn('fast');
      });

    });
  </script>
</body>

</html>