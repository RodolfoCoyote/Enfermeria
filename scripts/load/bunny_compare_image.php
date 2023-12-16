<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // TS

require '../../vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

$api_key = '67708a26-bc3d-4637-bce324a44a8d-9766-4ecb'; // Tu API Key de Bunny.net
$storageZoneName = 'rdi-enf-cdmx'; // Tu zona de almacenamiento

$num_med_record = $_POST['num_med_record'];
$step = $_POST['step'];
$side = $_POST['side'];

$client = new Client();

$response = $client->request('GET', "https://la.storage.bunnycdn.com/{$storageZoneName}/{$num_med_record}/{$step}/thumb/", [
    'headers' => [
        'AccessKey' => $api_key,
        'accept' => '*/*',
    ]
]);

$body = $response->getBody();
$files = json_decode($body, true);

$thumbs = '<div class="row post-carousel-twoCol-' . $side . ' post-carousel">';

foreach ($files as $file) {
    $thumbs .= "<img data-side=" . $side . " data-zoom='scripts/load/bunny_patient_image.php?filename=" . $file['ObjectName'] . "&num_med_record=" . $num_med_record . "&step=" . $step . "&type=zoom' src='scripts/load/bunny_patient_image.php?filename=" . $file['ObjectName'] . "&num_med_record=" . $num_med_record . "&step=" . $step . "' class='carousel-image'>";
}

$thumbs .= '</div>';
echo $thumbs;
