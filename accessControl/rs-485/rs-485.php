<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchNetworkInterfaces($host)
{
    $url = "https://$host/ISAPI/System/Serial/ports/1";
    $response = isAPI($url, 'GET');
    if (isset($response->error)) {
        return $response->error;
    }
    return [
        "enabled" => $response->enabled,
        "direction" => $response->direction,
        "mode" => $response->mode,
        "serialAddress" => $response->serialAddress,
        "baudRate" => $response->baudRate,
        "dataBits" => $response->dataBits,
        "stopBits" => $response->stopBits,
        "parityType" => $response->parityType,
        "flowCtrl" => $response->flowCtrl,
        "duplexMode" => $response->duplexMode,
    ];
}

// Example usage
echo json_encode(fetchNetworkInterfaces($host));
