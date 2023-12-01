<?php
session_start();

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

  <link rel="shortcut icon" href="../1/assets/img/favicon.png" type="image/x-icon" />
  <link rel="stylesheet" href="assets/compiled/css/app.css" />
  <link rel="stylesheet" href="assets/compiled/css/app-dark.css" />
</head>

<body>
  <div id="app">
    <?php require_once "templates/sidebar.php"; ?>
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
        <div class="page-heading">
          <div class="page-title">
            <div class="row">
              <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Inicio</h3>
                <p class="text-subtitle text-muted">
                </p>
              </div>

            </div>
          </div>
          <div class="page-content">
            <section class="row">
              <div class="col-12 col-lg-12">
                <div class="row">
                  <div class="col-lg-6 col-md-12 col-xs-12">
                    <a href="new_procedure.php">
                      <div class="card">
                        <div class="card-body px-4 py-4-5">
                          <div class="row">

                            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-7">
                              <h4 class="font-extrabold mb-0">Registrar procedimiento</h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-lg-6 col-md-12 col-xs-12">
                    <a href="view_procedures.php">
                      <div class="card">
                        <div class="card-body px-4 py-4-5">
                          <div class="row">

                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                              <h4 class="font-extrabold mb-0">Editar procedimiento</h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>

      <?php require_once("templates/footer.php"); ?>
    </div>
  </div>
  <script src="assets/static/js/initTheme.js"></script>
  <script src="assets/static/js/components/dark.js"></script>
  <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="assets/compiled/js/app.js"></script>
</body>

</html>