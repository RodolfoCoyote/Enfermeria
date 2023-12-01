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

	<link rel="shortcut icon" href="../1/assets/img/favicon.png" type="image/x-icon" />

	<link rel="stylesheet" href="assets/compiled/css/app.css" />
	<link rel="stylesheet" href="assets/compiled/css/app-dark.css" />


	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
	<link href="assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
	<style>
		.paciente_info {
			font-size: 17px;
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
					<div class="row">
						<div class="text-center col-md-12 col-xs-12 order-md-1 order-last">
							<h3 class="text-center">Registro de fotos.</h3>
							<div class="offset-md-3 col-md-6 col-xs-12">
								<a href="comparar_fotos.php?id=<?= $_GET['id']; ?>" type="button" class="btn btn-warning">Ver evolución del paciente</a>
								<div class="card">
									<div class="card-body bg-light">
										<?php
										$proced_id = $_GET['id'];
										$sql = "SELECT * FROM enf_procedures WHERE id = $proced_id;";
										$query = mysqli_query($conn, $sql);
										$row = mysqli_fetch_assoc($query);

										$tipo_injerto = ($row['type'] == 1) ? 'Capilar' : 'Barba';
										$date = strtotime($row['procedure_date']);
										echo "<strong>Número de Expediente: </strong>" . $row['num_med_record'] . "<br />";
										echo "<p class=\"paciente_info\"><strong>Nombre del paciente: </strong>" . $row['name'] . "<br/>";
										echo "<strong>Tipo de injerto: </strong>" . $tipo_injerto . "<br />";
										echo "<strong>Sala: </strong>" . $row['room'] . "<br />";
										echo "<strong>Especialista: </strong>" . $row['specialist'] . "<br />";
										echo "<strong>Fecha Procedimiento: </strong>" . date("d/m/Y", $date) . "</p>";
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="container">
						<div class="accordion accordion-flush" id="accordionFlushExample">
							<div class="accordion-item">
								<h2 class="accordion-header" id="flush-headingOne">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
										<h5>Fotos de Valoración</h5>
									</button>
								</h2>
								<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
									<div class="accordion-body">
										<div class="row">
											<div class="col-md-12">
												<div class="panel panel-primary">
													<div class="panel-heading">
														<h3></h3>
													</div>
													<div class="panel-body">
														<form action="">
															<div class="form-group">
																<input type="file" id="step-1" name="step-1[]" multiple>
															</div>
															<div class="form-group">
																<div id="image_preview" style="width:100%;">
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
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
	<script src="assets/static/js/initTheme.js"></script>
	<script src="assets/extensions/jquery/jquery.min.js"></script>
	<script src="assets/static/js/components/dark.js"></script>
	<script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script src="assets/compiled/js/app.js"></script>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
	<script src="assets/js/buffer.js" type="text/javascript"></script>
	<script src="assets/js/filetype.js" type="text/javascript"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	<script src="assets/js/fileinput.js" type="text/javascript"></script>
	<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/locales/es.js" type="text/javascript"></script>
	<script>
		$(document).ready(function() {
			$('#step-1').fileinput({
				allowedFileExtensions: ["jpg", "png", "heic", "jpeg", "mov", "mp4"],
				language: "es",
				uploadUrl: 'upload.php?proced=<?= $row['num_med_record']; ?>&step=1',
				initialPreviewAsData: true,
				showRemove: false,
				showCancel: false,
				initialPreview: [
					<?php
					$dirPath = "expedientes/" . $row['num_med_record'] . "/valoracion";
					$files = scandir("expedientes/" . $row['num_med_record'] . "/valoracion");
					foreach ($files as $file) {
						$filePath = $dirPath . '/' . $file;
						if (is_file($filePath)) {
							echo "'$filePath',";
						}
					} ?>
				],
				initialPreviewConfig: [
					<?php
					$dirPath = "expedientes/" . $row['num_med_record'] . "/valoracion";
					$files = scandir("expedientes/" . $row['num_med_record'] . "/valoracion");
					$i = 0;
					foreach ($files as $file) {
						$filePath = $dirPath . '/' . $file;
						if (is_file($filePath)) {
							echo "{caption: \"" . $file . "\", width: \"150px\", url: \"borrar_foto.php?file=$file&expediente=" . $row['num_med_record'] . "&step=1\", key: " . $i . ", zoomData: '$filePath', description: ''},";
							$i++;
						}
					} ?>

				]
			});
		});
	</script>
</body>

</html>