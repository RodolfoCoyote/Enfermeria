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
  <link rel="stylesheet" href="assets/css/style.css">

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
          <div class="page-title">
            <div class="row">
              <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Agregar nuevo:</h3>
                <div class="tabs">
                  <a data-type="divMedicines" class="tabs__button">
                    Medicamento
                  </a>
                  <a data-type="divSupplies" class="tabs__button">
                    Insumo
                  </a>
                </div>
                <p class="text-subtitle text-muted">
                </p>
              </div>
            </div>
          </div>
          <section class="section">
            <div class="card">
              <div class="card-header">

              </div>
              <div class="card-body">
                <section id="divMedicines" style="display:none;">
                  <div class="row">
                    <div class="col-md-6">
                      <form action="scripts/add/medicine.php" method="POST" class="formNewMedicine">
                        <input type="text" class="form-control" name="item_class_m" id="item_class_m" value="medicine">
                        <div class="form-group">
                          <label for="basicInput">Nombre del medicamento</label>
                          <input type="text" class="form-control" name="name_m" id="name_m" placeholder="">
                        </div>
                        <div class="form-group">
                          <label for="basicInput">Presentación</label>
                          <input type="text" class="form-control" name="presentation_m" id="presentation_m" placeholder="">
                        </div>
                        <div class="form-group">
                          <label for="basicInput">Gramaje</label>
                          <input type="text" class="form-control" name="dosage_m" id="dosage_m" placeholder="">
                        </div>
                        <div class="form-group">
                          <label for="basicInput">Cantidad que debe haber en bodega</label>
                          <input type="number" class="form-control" name="initial_stock_m" id="initial_stock_m" min=0 placeholder="">
                        </div>
                        <div class="form-group">
                          <label for="basicInput">Asignar a la clínica:</label>
                          <select class="form-control" id="clinic_m" name="clinic_m" required>
                            <option value=0 selected disabled readonly>Selecciona</option>
                            <option data-clinicname="CDMX" value=1>CDMX</option>
                            <option data-clinicname="Culiacán" value=2>Culiacán</option>
                            <option data-clinicname="Mazatlán" value=3>Mazatlán</option>
                            <option data-clinicname="Tijuana" value=4>Tijuana</option>
                          </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block me-1 mb-1">
                          Añadir a la lista de medicamentos
                        </button>
                      </form>
                    </div>
                  </div>
                </section>
                <section id="divSupplies" style="display:none;">
                  <div class="row">
                    <div class="col-md-6">
                      <form action="scripts/add/medicine.php" method="POST" class="formNewMedicine">
                        <input type="text" class="form-control" name="item_class_s" id="item_class_s" value="supplie">
                        <div class="form-group">
                          <label for="basicInput">Nombre del insumo</label>
                          <input type="text" class="form-control" name="name_s" id="name_s" placeholder="">
                        </div>
                        <div class="form-group">
                          <label for="basicInput">Unidad de Medida</label>
                          <input type="text" class="form-control" name="measure_s" id="measure_s" placeholder="">
                        </div>
                        <div class="form-group">
                          <label for="basicInput">Cantidad que debe haber en bodega</label>
                          <input type="number" class="form-control" name="initial_stock_s" id="initial_stock_s" min=0 placeholder="">
                        </div>
                        <div class="form-group">
                          <label for="basicInput">Asignar a la clínica:</label>
                          <select class="form-control" id="clinic_s" name="clinic_s" required>
                            <option value=0 selected disabled readonly>Selecciona</option>
                            <option data-clinicname="CDMX" value=1>CDMX</option>
                            <option data-clinicname="Culiacán" value=2>Culiacán</option>
                            <option data-clinicname="Mazatlán" value=3>Mazatlán</option>
                            <option data-clinicname="Tijuana" value=4>Tijuana</option>
                          </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block me-1 mb-1">
                          Añadir a la lista de insumos
                        </button>
                      </form>
                    </div>
                  </div>
                </section>
              </div>
            </div>
          </section>
        </div>
      </div>
      <?php require_once "templates/footer.php"; ?>
    </div>
  </div>

  <script src="assets/static/js/pages/jquery.js"></script>
  <script src="assets/static/js/initTheme.js"></script>
  <script src="assets/static/js/components/dark.js"></script>
  <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="assets/compiled/js/app.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.js"></script>
  <script src="assets/js/scripts.js"></script>

  <script>
    $(document).ready(function() {
      $(".tabs__button").click(function(e) {
        e.preventDefault();

        $("#divMedicines,#divSupplies").css('display', 'none');

        const tab = "#" + $(this).data('type');
        $(tab).fadeIn("slow");
      });
      $(".formNewMedicine").submit(function(e) {
        e.preventDefault();
        const method = $(this).attr('method');
        const url = $(this).attr('action');
        const formData = $(this).serialize();

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
              text: response.message,
              icon: 'success',
              timer: 2500, // 
              timerProgressBar: true,
              showConfirmButton: false
            }).then((result) => {
              location.reload();
            });
          } else {
            Swal.fire({
              title: 'Error 400',
              text: response.message,
              icon: 'error',
              timer: 2500,
              timerProgressBar: true,
              showConfirmButton: false // No muestra el botón de confirmación
            });
          }
        }).fail(function(response) {
          console.log(response)
          Swal.fire({
            title: 'Error 501',
            text: response.message,
            icon: 'error',
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: false // No muestra el botón de confirmación
          });
        });
      });
    });
  </script>
</body>

</html>