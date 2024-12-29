<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function blueTooth($host)
{
    $url = "https://$host/ISAPI/System/Bluetooth/deviceCfg?format=json&security=1&iv=4d705ddb6d17870ed5ad8fef9f4eb079";
    $response = isAPI($url, 'GET');
    if (isset($response->error)) {
        echo json_encode($response->error);
        return null;
    }
    return [
        "name" => $response->name,
        "enabled" => $response->enabled,
    ];
}
function openDoorEnabled($host)
{
    $url = "https://$host/ISAPI/AccessControl/bluetooth?format=json";
    $response = isAPI($url, 'GET');
    if (isset($response->error)) {
        echo json_encode($response->error);
        return null;
    }
    return [
        "openDoorEnabled" => $response->openDoorEnabled,
    ];
}
echo json_encode([
    "blueTooth" => blueTooth($host),
    "openDoorEnabled" => openDoorEnabled($host),
]);
