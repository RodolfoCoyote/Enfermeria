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
										<h6 class="dropdown-header">Hola, <?= $_SESSION['name']; ?></h6>
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
				<h3>Lista de insumos</h3>
				<!-- Basic Tables start -->
				<div class="card-body">
					<div class="table-responsive">
						<table class="table" id="table1">
							<thead>
								<tr>
									<th>ID</th>
									<th>Nombre del insumo</th>
									<th>Unidad de Medida</th>
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

	<div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel33">
						Editar insumo.
					</h4>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<i data-feather="x"></i>
					</button>
				</div>
				<form action="scripts/update/supply.php" method="POST" id="formUpdateMedicine">
					<div class="modal-body">
						<label for="medicamento_id">ID</label>
						<div class="form-group">
							<input id="med_id" name="id" type="text" placeholder="ID" class="form-control" readonly />
						</div>
						<label for="nombre">Nombre del insumo </label>
						<div class="form-group">
							<input id="name" name="name" type="Nombre del fármaco" placeholder="text" class="form-control" />
						</div>
						<label for="presentacion">Unidad de Medida </label>
						<div class="form-group">
							<input id="measure" name="measure" type="text" placeholder="Presentación" class="form-control" />
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
						<button type="submit" class="btn btn-success ms-1">
							<i class="bx bx-check d-block d-sm-none"></i>
							<span class="d-sm-block">Actualizar</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- El Modal -->
	<div class="modal" id="abastecerModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Cabecera del Modal -->
				<div class="modal-header">
					<h4 class="modal-title">Actualizar <strong id="spanNameMed"></strong></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Contenido del Modal -->
				<div class="modal-body">
					<div class="row">
						<div class="col-4 mx-auto text-center">
							<span>Cantidad que debe haber: <strong id="spanQtySala"></strong></span>
						</div>
						<div class="col-4 mx-auto text-center">
							<span>Cantidad actual:<br> <strong id="spanQtyActual"></strong></span>
						</div>
					</div>
					<div class="row">
						<div class="col-4 mx-auto text-center">
							Cantidad abastecida:<br>
							<input type="hidden" id="id_farmaco" name="id_farmaco">
							<input type="number" class="form-control" id="qty_abastecida" name="qty_abastecida" min=0>
						</div>
					</div>
				</div>

				<!-- Pie del Modal -->
				<div class="modal-footer">
					<button type="button" id="qtyAbastecida" class="btn btn-success" data-dismiss="modal">Guardar cambios</button>
				</div>

			</div>
		</div>
	</div>

	<script src="assets/static/js/initTheme.js"></script>
	<script src="assets/static/js/components/dark.js"></script>
	<script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script src="assets/compiled/js/app.js"></script>
	<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

	<script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.js"></script>

	<script>
		$(document).ready(function() {
			let jquery_datatable = $("#table1").DataTable({
				ajax: 'scripts/load/supplies.php',
				autoWidth: false,
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

			$("#formUpdateMedicine").submit(function(e) {
				e.preventDefault();
				let formData = $(this).serialize();
				let method = $(this).attr('method');
				let url = $(this).attr('action');

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
							timer: 2000, // Tiempo en milisegundos (en este caso, 3000 ms = 3 segundos)
							timerProgressBar: true, // Muestra una barra de progreso
							showConfirmButton: false
						}).then((result) => {
							location.reload();
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
		});

		$(document).on("click", ".ver_medicamento", function() {
			let fields = ["med_id", "name", "measure", "initial_stock"];

			let tr = $(this).closest('tr');
			let i = 0;

			tr.find('td').each(function() {
				$("#" + fields[i]).val($(this).text());
				i++;
			})
			$("#inlineForm").modal("show");
		});

		$(document).on("click", ".btn_abastecer", function() {
			let tr = $(this).closest('tr');
			let items = [0, 1, 3, 4, 5];
			let selectedData = [];

			tr.find('td').each(function(index) {
				if (items.includes(index)) {
					// Agrega el contenido de la celda al arreglo selectedData
					selectedData.push($(this).text());
				}
			});
			let item_id = selectedData[0];
			let name = selectedData[1];
			let initial_stock = selectedData[2];
			let current_stock = selectedData[3];
			let max = selectedData[4];

			$("#id_farmaco").val(item_id);
			$("#spanNameMed").html(name);
			$("#spanQtyActual").html(initial_stock);
			$("#spanQtySala").html(current_stock);

			$("#qty_abastecida").attr('max', max);
			$("#abastecerModal").modal("show");
		});

		$(document).on("click", "#qtyAbastecida", function(e) {
			e.preventDefault();

			var id_farmaco = $("#id_farmaco").val();
			var qty_abastecida = $("#qty_abastecida").val();

			$.ajax({
				type: "POST",
				url: 'scripts/update/qty_supply.php',
				data: {
					id: id_farmaco,
					qty_abastecida: qty_abastecida
				},
				dataType: 'json'
			}).done(function(response) {
				if (response.success) {
					Swal.fire({
						title: 'Listo!',
						text: response.message,
						icon: 'success',
						timer: 2000, // Tiempo en milisegundos (en este caso, 3000 ms = 3 segundos)
						timerProgressBar: true, // Muestra una barra de progreso
						showConfirmButton: false
					}).then((result) => {
						location.reload();
					});
				}
			}).fail(function(response) {
				console.log(response);
			});
		});
	</script>
</body>

</html>