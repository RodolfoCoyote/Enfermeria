<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.


require_once "../bunnycdn-storage.php";
$num_med_record = $_GET['num_med_record'];
$step = $_GET['step'];

try {
	$preview = $config = $errors = [];

	$bunnyCDNStorage = new BunnyCDNStorage("rdi-enf-cdmx", "67708a26-bc3d-4637-bce324a44a8d-9766-4ecb", "LA");

	foreach ($_FILES['file']['name'] as $position => $fileName) {
		// Ruta en BunnyCDN donde deseas almacenar el archivo original
		$rutaBunnyCDNOriginal = "/rdi-enf-cdmx/" . $num_med_record . "/" . $step . "/";
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

		/*		$imagick = new Imagick($nombreArchivoLocal);

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
*/
		// Cargar la miniatura a BunnyCDN $archivoTemporal
		if (!$bunnyCDNStorage->uploadFile($nombreArchivoLocal, $rutaBunnyCDNThumbnail . $nombreArchivoThumbnailBunnyCDN)) {
			throw new Exception('Error al subir la miniatura a BunnyCDN.');
		}

		$preview[] = "<img data-zoom='scripts/load/bunny_patient_image.php?filename=" . $nombreArchivoOriginalBunnyCDN . "&num_med_record=" . $num_med_record . "&step=" . $step . "&type=zoom' src='scripts/load/bunny_patient_image.php?filename=" . $nombreArchivoOriginalBunnyCDN . "&num_med_record=" . $num_med_record . "&step=" . $step . "' class='file-preview-image'>";
		$config[] = [
			'caption' => $nombreArchivoOriginalBunnyCDN, // server api to delete the file based on key
		];
	}

	$out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => false];
	echo json_encode($out); // return json data

} catch (Exception $e) {
	echo "Error: " . $e->getMessage();
}
