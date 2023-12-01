<?php
header('Content-Type: application/json');
$outData = upload(); // a function to upload the bootstrap-fileinput files
echo json_encode($outData); // return json data
exit();

function upload()
{
    $preview = $config = $errors = [];

    $input = 'step-' . $_GET['step']; // input name 

    $expediente = $_GET['proced'];

    if (empty($_FILES[$input])) {
        return [];
    }
    $total = count($_FILES[$input]['name']);

    $path = 'expedientes/' . $expediente . '/';
    if ($_GET['step'] == 1) {
        $path = $path . "valoracion/";
    } else if ($_GET['step'] == 2) {
        $path = $path . "pre/";
    } else if ($_GET['step'] == 3) {
        $path = $path . "diseno/";
    } else if ($_GET['step'] == 4) {
        $path = $path . "post/";
    } else if ($_GET['step'] == 5) {
        $path = $path . "24horas/";
    } else if ($_GET['step'] == 6) {
        $path = $path . "10dias/";
    } else if ($_GET['step'] == 7) {
        $path = $path . "1mes/";
    } else if ($_GET['step'] == 8) {
        $path = $path . "3meses/";
    } else if ($_GET['step'] == 9) {
        $path = $path . "6meses/";
    } else if ($_GET['step'] == 10) {
        $path = $path . "9meses/";
    } else if ($_GET['step'] == 11) {
        $path = $path . "12meses/";
    }

    for ($i = 0; $i < $total; $i++) {
        $tmpFilePath = $_FILES[$input]['tmp_name'][$i];
        $fileName = $_FILES[$input]['name'][$i];
        $fileSize = $_FILES[$input]['size'][$i];


        if ($tmpFilePath != "") {
            //Setup new file path
            $newFilePath = $path . $fileName;

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            mkdir($path . "thumb/", 0777, true);

            $newFileUrl = $path . $fileName;


            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                createThumbnail($newFilePath, $path . "thumb/");

                $fileId = $fileName . $i;
                $preview[] = $path . "thumb/" . $fileName;
                $config[] = [
                    'key' => $fileId,
                    'caption' => $fileName,
                    'size' => $fileSize,
                    'downloadUrl' => $newFileUrl,
                    'url' => 'http://localhost/delete.php', // server api to delete the file based on key
                ];
            } else {
                $errors[] = $fileName;
            }
        } else {
            $errors[] = $fileName;
        }
    }
    $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];
    if (!empty($errors)) {
        $out['error'] = 'Oh snap! We could not upload now. Please try again later.';
    }
    return $out;
}



function createThumbnail($file, $target)
{
    $filename = basename($file);

    $allowed_formats = ['jpg', 'jpeg', 'png'];
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    if (in_array(strtolower($extension), $allowed_formats)) {
        $imagick = new Imagick($file);

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

        $imagick->thumbnailImage($newWidth, $newHeight);
        $imagick->setImageCompressionQuality(80);

        $target = $target . $filename;
        $imagick->writeImage($target);
    }
}
