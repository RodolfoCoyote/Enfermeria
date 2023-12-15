<?php
header('Content-Type: application/json');
require '../../vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

$api_key = '67708a26-bc3d-4637-bce324a44a8d-9766-4ecb'; // Tu API Key de Bunny.net
$storageZoneName = 'rdi-enf-cdmx'; // Tu zona de almacenamiento
$num_med_record = $_POST['num_med_record'];
$step = $_POST['step'];

$client = new Client();

try {
    $response = $client->request('GET', "https://la.storage.bunnycdn.com/{$storageZoneName}/{$num_med_record}/{$step}/thumb/", [
        'headers' => [
            'AccessKey' => $api_key,
            'accept' => '*/*',
        ]
    ]);

    $body = $response->getBody();
    $files = json_decode($body, true);
    $images = [];

    foreach ($files as $file) {
        $images[] = "<img data-zoom='scripts/load/bunny_patient_image.php?filename=" . $file['ObjectName'] . "&num_med_record=" . $num_med_record . "&step=" . $step . "&type=zoom' src='scripts/load/bunny_patient_image.php?filename=" . $file['ObjectName'] . "&num_med_record=" . $num_med_record . "&step=" . $step . "' class='file-preview-image'>";
        $filesListConfig[] = [
            'caption' => $file['ObjectName'],
            'key' => rand("100", "500"), // Asigna una clave única
        ];
    }

    echo json_encode([
        "message" => "success",
        "initialPreview" => $images,
        "initialPreviewConfig" => $filesListConfig

    ]);
} catch (RequestException $e) {
    echo "Error: " . $e->getMessage();
}
