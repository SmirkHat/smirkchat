<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$api_key = 'YOUR_API_KEY_HERE';
	$prompt = $_POST['prompt'];



	$ch = curl_init('https://api.pawan.krd/cosmosrp-it/v1/chat/completions');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json',
		'Authorization: Bearer ' . $api_key
	]);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

	$response = curl_exec($ch);
	curl_close($ch);

	// For debugging, return the response as is
	echo $response;
}
