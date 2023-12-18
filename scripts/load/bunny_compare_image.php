<?php
ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // TS

require '../../vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

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
