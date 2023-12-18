<?php
session_start();

if (!isset($_SESSION['user_name']) || !isset($_GET['clinic'])) {
  header('Location: login.php'); // Redirigir al formulario de inicio de sesión
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inventario de fármacos | <?php echo date("d-m-Y H:m") ?> </title>

  <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon" />

  <link rel="stylesheet" href="assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css" />

  <link rel="stylesheet" href="./assets/compiled/css/table-datatable-jquery.css" />
  <link rel="stylesheet" href="./assets/compiled/css/app.css" />
  <link rel="stylesheet" href="./assets/compiled/css/app-dark.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
                <!-- NOTIFICACIONES
                  <li class="nav-item dropdown me-3">
                    <a
                      class="nav-link active dropdown-toggle text-gray-600"
                      href="#"
                      data-bs-toggle="dropdown"
                      data-bs-display="static"
                      aria-expanded="false"
                    >
                      <i class="bi bi-bell bi-sub fs-4"></i>
                      <span class="badge badge-notification bg-danger">7</span>
                    </a>
                    <ul
                      class="dropdown-menu dropdown-menu-end notification-dropdown"
                      aria-labelledby="dropdownMenuButton"
                    >
                      <li class="dropdown-header">
                        <h6>Notifications</h6>
                      </li>
                      <li class="dropdown-item notification-item">
                        <a class="d-flex align-items-center" href="#">
                          <div class="notification-icon bg-primary">
                            <i class="bi bi-cart-check"></i>
                          </div>
                          <div class="notification-text ms-4">
                            <p class="notification-title font-bold">
                              Successfully check out
                            </p>
                            <p class="notification-subtitle font-thin text-sm">
                              Order ID #256
                            </p>
                          </div>
                        </a>
                      </li>
                      <li class="dropdown-item notification-item">
                        <a class="d-flex align-items-center" href="#">
                          <div class="notification-icon bg-success">
                            <i class="bi bi-file-earmark-check"></i>
                          </div>
                          <div class="notification-text ms-4">
                            <p class="notification-title font-bold">
                              Homework submitted
                            </p>
                            <p class="notification-subtitle font-thin text-sm">
                              Algebra math homework
                            </p>
                          </div>
                        </a>
                      </li>
                      <li>
                        <p class="text-center py-2 mb-0">
                          <a href="#">See all notification</a>
                        </p>
                      </li>
                    </ul>
                  </li> -->
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
        <h3>Lista de fármacos</h3>
        <!-- Basic Tables start -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table" id="table1">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre del fármaco</th>
                  <th>Presentación</th>
                  <th>Gramaje</th>
                  <th>Cant. que debe haber</th>
                  <th>Cant. actual</th>
                  <th>Por abastecer</th>
                  <th>Opciones</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
        <!-- Basic Tables end -->
      </div>
      <?php require_once "templates/footer.php" ?>
    </div>
  </div>


  <!--login form Modal -->
  <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel33">
            Editar fármaco.
          </h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <form action="scripts/actualizar_medicamento.php" method="POST">
          <div class="modal-body">
            <label for="medicamento_id">ID</label>
            <div class="form-group">
              <input id="med_id" name="id" type="text" placeholder="ID" class="form-control" readonly />
            </div>
            <label for="nombre">Nombre del fármaco </label>
            <div class="form-group">
              <input id="name" name="name" type="Nombre del fármaco" placeholder="text" class="form-control" />
            </div>
            <label for="presentacion">Presentación </label>
            <div class="form-group">
              <input id="presentation" name="presentation" type="text" placeholder="Presentación" class="form-control" />
            </div>
            <label for="gramaje">Gramaje </label>
            <div class="form-group">
              <input id="dosage" name="dosage" type="text" placeholder="Gramaje" class="form-control" />
            </div>
            <label for="cantidad_sala">Cantidad que debe haber en sala </label>
            <div class="form-group">
              <input id="initial_stock" name="initial_stock" type="number" placeholder="" class="form-control" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-sm-block">Cerrar</span>
            </button>
            <button type="submit" class="btn btn-success ms-1" data-bs-dismiss="modal">
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
  <script src="assets/extensions/jquery/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

  <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
  <script>
    let jquery_datatable = $("#table1").DataTable({
      ajax: 'scripts/load/medicines.php',
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
      },
      dom: 'Bfrltip',
      buttons: [
        'excel', 'pdf'
      ]
    });

    const setTableColor = () => {
      document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
        dt.classList.add('pagination-primary')
      })
    }
    setTableColor()
    jquery_datatable.on('draw', setTableColor)

    $(document).on("click", ".ver_medicamento", function() {
      let fields = ["med_id", "name", "presentation", "dosage", "initial_stock"];

      let tr = $(this).closest('tr');
      let i = 0;

      tr.find('td').each(function() {
        $("#" + fields[i]).val($(this).text());
        i++;
      })
      $("#inlineForm").modal("show");
    });

    $(document).on("click", ".btn_abastecer", function() {
      let medicamento_id = $(this).attr('medicamento_id');

      $("#id_farmaco").val(medicamento_id);

      let qty_sala = $(this).data('sala');
      let qty_actual = $(this).data('actual');
      let qty_abastecida = qty_sala - qty_actual;


      $("#spanQtyActual").html(qty_actual);
      $("#spanQtySala").html(qty_sala);
      $("#qty_abastecida").val(qty_abastecida);

      $("#abastecerModal").modal("show");
    });
  </script>
</body>

</html>