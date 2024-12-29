<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchNetworkInterfaces($host) {
    $url = "https://$host/ISAPI/AccessControl/bluetooth?format=json";
    $response = isAPI($url, 'GET');
    if (isset($response->error)) {
        echo json_encode($response->error);
        return null;
    }
    return [
        "openDoorEnabled" => $response->openDoorEnabled ? 'true' : 'false',
    ];
}

echo json_encode(fetchNetworkInterfaces($host));
