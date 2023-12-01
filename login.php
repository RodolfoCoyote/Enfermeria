<?php
session_start();

if (isset($_SESSION['user_name'])) {
  header('Location: index.php'); // Redirigir al formulario de inicio de sesión
  exit();
}

?>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Iniciar Sesión - Enfermería RDI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="assets/css/login-style.css" />
</head>

<body>
  <section>
    <div class="form-box">
      <div class="form-value">
        <form method="POST" id="loginForm">
          <h2>Login</h2>
          <div class="inputbox">
            <ion-icon name="person-outline"></ion-icon>
            <input type="text" name="username" id="username" required />
            <label for="">Usuario</label>
          </div>
          <div class="inputbox">
            <ion-icon name="lock-closed-outline"></ion-icon>
            <input type="password" name="password" id="password" required />
            <label for="">Password</label>
          </div>
          <div class="forget">
            <label for=""> <input type="checkbox" value="rememberme" id="rememberme" />Recordarme</label>
          </div>
          <button type="submit">Entrar</button>
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
      $("#recoveryPassword").click(function(e) {
        e.preventDefault();
        showSweetAlert(
          ":(",
          "Por favor, contacta a administración",
          " ",
          false,
          true,
          true
        );
      });
      $("#loginForm").submit(function(e) {
        e.preventDefault();
        var username = $("#username").val();
        var password = $("#password").val();
        var rememberme = $("#rememberme").val();
        // Crear un objeto con los datos recolectados
        var userData = {
          username: username,
          password: password,
          rememberme: rememberme,
        };

        $.ajax({
            url: "scripts/login.php",
            method: "POST",
            data: userData,
            dataType: "json",
          })
          .done(function(response) {
            if (response.message === "success") {
              showSweetAlert(
                "Hola!",
                "Buen día :)",
                "success",
                1400,
                false,
                false
              );
              Swal.fire({
                title: "Hola!",
                text: " Buen día :)",
                icon: "success",
                showConfirmButton: false,
                timer: 1700, // Tiempo en milisegundos (1.5 segundos)
              }).then(function() {
                window.location.href = "index.php";
              });
            } else if (response.message === "fail") {
              Swal.fire({
                title: "Credenciales incorrectas",
                text: "",
                icon: "error",
                //backdrop: "linear-gradient(yellow, orange)",
                background: "white",
                timer: 1700, // Tiempo en milisegundos (en este caso, 3000 ms = 3 segundos)
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