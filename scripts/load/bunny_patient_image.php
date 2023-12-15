<?php
require '../../vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

$api_key = '67708a26-bc3d-4637-bce324a44a8d-9766-4ecb'; // Tu API Key de Bunny.net
$storageZoneName = 'rdi-enf-cdmx'; // Tu zona de almacenamiento
$num_med_record = $_GET['num_med_record'];
$step = $_GET['step'];
$directoryPath = $num_med_record . "/" . $step . "/thumb/";
if ($_GET['type'] == 'zoom') {
    $directoryPath = $num_med_record . "/" . $step . "/";
}

$client = new Client();

try {

    $file_name = $_GET['filename'];
    $img_url = 'https://la.storage.bunnycdn.com/rdi-enf-cdmx/' . $directoryPath . $file_name;
    $get_image = $client->request('GET', $img_url, [
        'headers' => [
            'AccessKey' => '67708a26-bc3d-4637-bce324a44a8d-9766-4ecb',
            'accept' => '*/*',
        ],
    ]);

    // Salida directa del contenido de la imagen
    $body_image = $get_image->getBody()->getContents();
    header('Content-Type: image/jpeg'); // Asegúrate de establecer el tipo de contenido correcto
    echo $body_image;
    exit;
} catch (RequestException $e) {
    echo "Error: " . $e->getMessage();
}
