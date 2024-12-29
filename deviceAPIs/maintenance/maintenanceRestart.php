<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchNetworkInterfaces($host) {
    $url = "https://$host/ISAPI/VCS/wireshark/capture/capabilities";
    $response = isAPI($url, 'GET');
    if (isset($response->error)) {
        echo $response->error;
        return null;
    }
    return $response;
}

// Example usage
echo json_encode(fetchNetworkInterfaces($host));
