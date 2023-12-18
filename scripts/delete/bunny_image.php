<?php

header('Content-Type: application/json');
require '../../vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

$num_med_record = $_GET['num_med_record'];
$step = $_GET['step'];
$clinic = $_GET['clinic'];
$filename = $_GET['filename'];

try {
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
	$client = new Client();

	$response = $client->request('DELETE', "https://la.storage.bunnycdn.com/{$storageZoneName}/{$num_med_record}/{$step}/thumb/{$filename}", [
		'headers' => [
			'AccessKey' => $api_key,
			'accept' => '*/*',
		]
	]);

	$response = $client->request('DELETE', "https://la.storage.bunnycdn.com/{$storageZoneName}/{$num_med_record}/{$step}/{$filename}", [
		'headers' => [
			'AccessKey' => $api_key,
			'accept' => '*/*',
		]
	]);

	echo json_encode(['success' => true]);
} catch (RequestException $e) {
	echo json_encode(['error' => $filename]);
}
