<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchNetworkInterfaces($host) {
    $url = "https://$host/ISAPI/AccessControl/bluetooth?format=json";
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET

    $ch = deviceAuth($ch);
    
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    } else {
        $data = json_decode($response, true);
        $openDoorEnabled = $data['openDoorEnabled'];
        echo ($openDoorEnabled ? 'true' : 'false');
    }

    // Close cURL session
    curl_close($ch);
}

// Example usage
fetchNetworkInterfaces($host);