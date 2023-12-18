<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.


require_once "../bunnycdn-storage.php";
$num_med_record = $_GET['num_med_record'];
$step = $_GET['step'];

try {

	$clinic = $_GET['clinic'];


	switch ($clinic) {
		case 1: // CDMX
			$api_key = '67708a26-bc3d-4637-bce324a44a8d-9766-4ecb';
			$storageZoneName = 'rdi-enf-cdmx';
			break;
		case 2: // Culiacán
			$api_key = '90086039-bce6-43d4-bc3dc22d891c-ee35-4e6b';
			$storageZoneName = 'rdi-enf-cul';
			break;
		case 3: // Mazatlán
			$api_key = 'bfae151f-118b-4428-acc65e702314-1987-4471';
			$storageZoneName = 'rdi-enf-mzt';
			break;
		case 4: // Tijuana
			$api_key = 'bc1fee1f-25c4-43cc-9662f7fd5588-a964-497b';
			$storageZoneName = 'rdi-enf-tij';
			break;
		default:
			echo 0;
	}

	$preview = $config = $errors = [];

	$bunnyCDNStorage = new BunnyCDNStorage($storageZoneName, $api_key, "LA");

	foreach ($_FILES['file']['name'] as $position => $fileName) {
		// Ruta en BunnyCDN donde deseas almacenar el archivo original
		$rutaBunnyCDNOriginal = $storageZoneName . "/" . $num_med_record . "/" . $step . "/";
		$rutaBunnyCDNThumbnail = $rutaBunnyCDNOriginal . "thumb/";

		// Nombre del archivo original en BunnyCDN (puedes mantener el mismo nombre o cambiarlo según tus necesidades)
		$nombreArchivoOriginalBunnyCDN = $_FILES['file']['name'][$position];

		// Nombre del archivo de la miniatura en BunnyCDN (puedes mantener el mismo nombre o cambiarlo según tus necesidades)
		$nombreArchivoThumbnailBunnyCDN = $nombreArchivoOriginalBunnyCDN;

		// Nombre del archivo local
		$nombreArchivoLocal = $_FILES['file']['tmp_name'][$position];

		// Cargar el archivo original a BunnyCDN
		if (!$bunnyCDNStorage->uploadFile($nombreArchivoLocal, $rutaBunnyCDNOriginal . $nombreArchivoOriginalBunnyCDN)) {
			throw new Exception('Error al subir el archivo original a BunnyCDN.');
		}

		$imagick = new Imagick($nombreArchivoLocal);

		$width = $imagick->getImageWidth();
		$height = $imagick->getImageHeight();

		$max = 250;

		if ($width > $max || $height > $max) {
			if ($width > $height) {
				$newWidth = round($max);
				$newHeight = round($max / ($width / $height));
			} else {
				$newHeight = round($max);
				$newWidth = round($max * ($width / $height));
			}
		} else {
			$newWidth = $width;
			$newHeight = $height;
		}

		// Generar miniatura
		$imagick->thumbnailImage($newWidth, $newHeight);
		$imagick->setImageCompressionQuality(80);

		// Obtener la miniatura generada por ImageMagick
		$imagenGenerada = $imagick->getImageBlob();
		// Guardar el blob como un archivo temporal
		$archivoTemporal = tempnam(sys_get_temp_dir(), 'thumbnail_');
		file_put_contents($archivoTemporal, $imagenGenerada);

		// Cargar la miniatura a BunnyCDN $archivoTemporal
		if (!$bunnyCDNStorage->uploadFile($archivoTemporal, $rutaBunnyCDNThumbnail . $nombreArchivoThumbnailBunnyCDN)) {
			throw new Exception('Error al subir la miniatura a BunnyCDN.');
		}

		$preview[] = "<img data-zoom='scripts/load/bunny_patient_image.php?filename=" . $nombreArchivoOriginalBunnyCDN . "&clinic=" . $clinic . "&num_med_record=" . $num_med_record . "&step=" . $step . "&type=zoom' src='scripts/load/bunny_patient_image.php?filename=" . $nombreArchivoOriginalBunnyCDN . "&clinic=" . $clinic . "&num_med_record=" . $num_med_record . "&step=" . $step . "' class='file-preview-image'>";
		$config[] = [
			'caption' => $nombreArchivoOriginalBunnyCDN,
			'key' => rand("100", "500"), // Asigna una clave única
			'url' => "scripts/delete/bunny_image.php?filename={$nombreArchivoOriginalBunnyCDN}&clinic={$clinic}&num_med_record={$num_med_record}&step={$step}"
		];
	}

	$out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => false];
	echo json_encode($out); // return json data

} catch (Exception $e) {
	echo "Error: " . $e->getMessage();
}
