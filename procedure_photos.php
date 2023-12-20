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
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.4/swiper-bundle.css'>
	<link rel="stylesheet" href="assets/extensions/cards/style.css">

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
							<h5 class="text-center">Registro de fotos.</h5>
							<div class="mx-auto col-md-6 col-xs-12">
								<a href="comparar_fotos.php?id=<?= $_GET['id']; ?>" type="button" class="btn btn-warning">Ver evolución del paciente</a>
								<div class="card">
									<div class="card-body">
										<?php
										$proced_id = $_GET['id'];
										$sql = "SELECT * FROM enf_procedures WHERE id = $proced_id;";
										$query = mysqli_query($conn, $sql);
										$row = mysqli_fetch_assoc($query);

										$tipo_injerto = ($row['type'] == 1) ? 'Capilar' : 'Barba';
										$date = strtotime($row['procedure_date']);

										switch ($row['clinic']) {
											case 1:
												$clinic_label = "CDMX";
												break;
											case 2:
												$clinic_label = "Culiacán";
												break;
											case 3:
												$clinic_label = "Mazatlán";
												break;
											case 4:
												$clinic_label = "Tijuana";
												break;
											default:
												$clinic_label = "Clínica no asignada";
										}

										echo "<h3 style='color:#e0ac44;' class='card-title'>{$row['name']}</h3>";
										echo "<p><span style='font-size:20px;' class='badge bg-secondary'>#{$row['num_med_record']}</span></p>";
										echo "<p><span style='font-size:20px;' class='badge bg-primary'>{$tipo_injerto}</span>";
										echo "<span style='font-size:20px;' class='badge bg-light'>{$clinic_label}</span></p>";

										echo "<p style='font-size:20px;'><strong>Sala: </strong>" . $row['room'] . "<br />";
										echo "<strong>Especialista: </strong>" . $row['specialist'] . "<br />";
										echo "<strong>Fecha Procedimiento: </strong>" . date("d/m/Y", $date) . "</p>";
										?>
									</div>
									<input type="hidden" id="num_med_record" name="num_med_record" value="<?= $row['num_med_record'] ?>">
									<input type="hidden" id="clinic" name="clinic" value="<?= $row['clinic']; ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="slider">
						<div class="swiper people__slide">
							<div class="swiper-wrapper">
							</div>
						</div>
					</div>
					<div class="inputfile-container">
						<input type="file" id="file" name="file[]" multiple>
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

	<script src='https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.4/swiper-bundle.min.js'></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
		$(document).ready(function() {
			$(".inputfile-container").css('display', 'none');
			var folders = ["pre", "diseno", "post", "24horas", "10dias", "1mes", "3meses", "6meses", "9meses", "12meses", "18meses"];
			var folders_name = ["Pre Procedimiento", "Diseño", "Post Procedimiento", "24 Horas", "10 Días", "1 Mes", "3 Meses", "6 Meses", "9 Meses", "12 Meses", "18 Meses"];
			var i = 0;
			let container = $(".swiper-wrapper");
			var num_med_record = $("#num_med_record").val();
			var clinic = $("#clinic").val();

			folders.forEach(function(folder) {
				let btn_disabled = (i > 0) ? 'style="display:none;"' : '';

				let swiperSlide = `
				<div class="swiper-slide">
					<div class="people__card">
					<div class="people__image">
						<img
						src="https://www.losreyesdelinjerto.com/assets/img/leon-footer.webp"
						style="width:50%;height:auto;">
					</div>
					<div class="people__info">
						<ul class="people__social">
						</ul>
						<h3 class="people__name">${folders_name[i]}</h3>
					</div>
					<div class="people__btn" ${btn_disabled}>
						<a class="view_imgs" href="#" data-clinic="${clinic}" data-step="${folder}" data-nummedrecord="${num_med_record}">Ver fotos</a>
					</div>
					</div>
				</div>`;

				$(".swiper-wrapper").append(swiperSlide);
				i++;
			});

			$('#file').fileinput({});

			const swiper = new Swiper(".swiper", {
				loop: false,
				slidesPerView: "auto",
				centeredSlides: true,
				observeParents: !0,
				observer: !0,
			});

			swiper.on('slideChangeTransitionEnd', function() {
				$(".inputfile-container").fadeOut('slow');
				$(".people__btn").css('display', 'none');

				$(swiper.el).find('.swiper-slide-active .people__btn').css('display', 'block');
			});

		});
	</script>
	<script>
		$(document).on('click', '.view_imgs', function(e) {
			e.preventDefault();
			let num_med_record = $(this).data('nummedrecord');
			let step = $(this).data('step');
			let clinic = $(this).data('clinic');
			console.log(num_med_record);
			console.log(step);

			Swal.fire({
				title: "Cargando...",
				allowOutsideClick: false,
				showConfirmButton: false,
			});

			$.ajax({
					data: {
						num_med_record: num_med_record,
						step: step,
						clinic: clinic
					},
					dataType: "json",
					method: "POST",
					url: "scripts/load/bunny_dir.php",
				})
				.done(function(response) {
					console.log(response);

					$(".inputfile-container").fadeIn("slow");
					$('#file').fileinput('destroy');

					$('#file').fileinput({
						allowedFileExtensions: ["jpg", "png", "heic", "jpeg", "mov", "mp4"],
						language: "es",
						uploadUrl: 'scripts/add/bunny_images.php?clinic=' + clinic + '&num_med_record=' + num_med_record + '&step=' + step,
						showRemove: false,
						showCancel: false,
						initialPreview: response.initialPreview,
						initialPreviewConfig: response.initialPreviewConfig,
						initialPreviewAsData: false,
					});
					$(".kv-file-rotate,.file-drag-handle").css('display', 'none');

					$('html, body').animate({
						scrollTop: $(document).height() - $(window).height()
					}, 'slow');
				})
				.fail(function(response) {
					console.log(response);
				}).always(function() {
					// Oculta la alerta de carga, independientemente de si la solicitud AJAX fue exitosa o no
					Swal.close();
				});

		});
	</script>
	<script src="assets/extensions/cards/script.js"></script>
</body>

</html>