<?php
session_start();

/*if (isset($_SESSION['user_name'])) {
  header('Location: index.php'); // Redirigir al formulario de inicio de sesión
  exit();
}
*/
?>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Registro de Usuarios - Enfermería RDI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="assets/css/login-style.css" />
  <style>
    .form-control {
      background-color: transparent;
      border-color: transparent;
      color: #e0ac44;
    }

    .form-control:hover {
      background-color: transparent;
      border-color: transparent;
      color: #e0ac44;
    }

    .form-control:active {
      background-color: transparent;
      border-color: transparent;
      color: #e0ac44;
    }

    #view_password {
      cursor: pointer;
    }
  </style>
</head>

<body>
  <section>
    <div class="form-box">
      <div class="form-value">
        <form method="POST" id="signupForm">
          <h2>Registro Usuarios</h2>
          <div class="inputbox">
            <ion-icon name="person"></ion-icon>
            <input type="text" name="name" id="name" required />
            <label for="">Nombre y Apellido</label>
          </div>
          <div class="inputbox">
            <ion-icon name="person-outline"></ion-icon>
            <input type="text" name="nickname" id="nickname" required />
            <label for="">Usuario</label>
          </div>
          <div class="inputbox">
            <ion-icon id="view_password" name="eye-outline"></ion-icon>
            <input type="password" name="password" id="password" required />
            <label for="">Password</label>
          </div>
          <div class="inputbox">
            <select class="form-control" name="clinic" id="clinic" required>
              <option value=0 disabled selected>Clinica</option>
              <option value=1>CDMX</option>
              <option value=2>Culiacán</option>
              <option value=3>Mazatlán</option>
              <option value=4>Tijuana</option>
              <option value=5>Todas</option>
            </select>

          </div>
          <button type="submit">Registrar</button>
        </form>
      </div>
    </div>
  </section>
  <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <!-- partial -->

  <!--  Import Js Files -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/js/custom.js"></script>
  <!--  core files -->

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#signupForm").submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        console.log(formData);
        $.ajax({
            url: "scripts/add/user.php",
            method: "POST",
            data: formData,
            dataType: "json",
          })
          .done(function(response) {
            if (response.success) {

              Swal.fire({
                title: "Listo!",
                text: " Usuario registrado :)",
                icon: "success",
                showConfirmButton: false,
                timer: 3000, // Tiempo en milisegundos (1.5 segundos)
              }).then(function() {
                window.location.href = "signup.php";
              });
            } else if (response.success == false) {
              Swal.fire({
                title: "Error",
                text: response.message,
                icon: "error",
                //backdrop: "linear-gradient(yellow, orange)",
                background: "white",
                timer: 2300, // Tiempo en milisegundos (en este caso, 3000 ms = 3 segundos)
                timerProgressBar: true, // Muestra una barra de progreso
                showConfirmButton: false, // No muestra el botón de confirmación
              });
            }
          })
          .fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
            Swal.fire({
              title: "Ocurrió un error",
              text: "Por favor, contacta a administración",
              icon: "error",
              timer: 1700, // Tiempo en milisegundos (en este caso, 3000 ms = 3 segundos)
              timerProgressBar: true, // Muestra una barra de progreso
              showConfirmButton: false, // No muestra el botón de confirmación
            });
          });
      });

      $("#view_password").mousedown(function() {
        // Iniciar la acción
        $("#password").attr('type', 'text');
      }).mouseup(function() {
        // Detener la acción cuando se suelta el botón del mouse
        $("#password").attr('type', 'password');
      }).mouseleave(function() {
        // Detener la acción si el mouse deja el elemento
        $("#password").attr('type', 'password');
      });
    });

    function showSweetAlert(
      title,
      text,
      icon,
      timer,
      timerProgressBar,
      showConfirmButton
    ) {
      Swal.fire({
        title: title || "Error",
        text: text || "Contacta a administración",
        icon: icon || "error",
        timer: timer, // Tiempo en milisegundos (en este caso, 3000 ms = 3 segundos)
        timerProgressBar: timerProgressBar || false, // Muestra una barra de progreso
        showConfirmButton: showConfirmButton || false, // No muestra el botón de confirmación
      });
    }
  </script>
</body>

</html>