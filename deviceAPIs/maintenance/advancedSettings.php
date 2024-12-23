<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchNetworkInterfaces($host) {
    $url = 'https://192.168.0.116/ISAPI/AccessControl/EngineeringModeMgr/cardReader/1/ReaderEngineeringModeParams?format=json';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET

    // Set authentication credentials
    $username = "admin";
    $password = "12345678m";
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    // Execute cURL request
    $response = curl_exec($ch);
    // Check for errors
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    } else {
        // Print response
        $advSettingReturn = [
            "antiSpoofingDetParams" => [
                "customEnabled" => (json_decode($response)->antiSpoofingDetParams->customEnabled) ? 'true' : 'false',
                "antiSpoofingDetLevel" => json_decode($response)->antiSpoofingDetParams->antiSpoofingDetLevel,
                "antiSpoofingDetThreshold" => json_decode($response)->antiSpoofingDetParams->antiSpoofingDetThreshold,
                "maskAntiSpoofingDetThreshold" => json_decode($response)->antiSpoofingDetParams->maskAntiSpoofingDetThreshold,
                "antiAttackEnabled" => (json_decode($response)->antiSpoofingDetParams->antiAttackEnabled) ? 'true' : 'false',
                "antiAttackLockTime" => json_decode($response)->antiSpoofingDetParams->antiAttackLockTime,
            ],
            "readerVersion" => [
                "BSPVersion" => json_decode($response)->readerVersion->BSPVersion,
                "DSPVersion" => json_decode($response)->readerVersion->DSPVersion,
                "engineVersion" => json_decode($response)->readerVersion->engineVersion,
                "faceAlgorithmVersion" => json_decode($response)->readerVersion->faceAlgorithmVersion,
                "antiSpoofingAlgorithmVersion" => json_decode($response)->readerVersion->antiSpoofingAlgorithmVersion,
            ]
        ];
        print_r(json_encode($advSettingReturn));
    }
    curl_close($ch);
}
fetchNetworkInterfaces($host);