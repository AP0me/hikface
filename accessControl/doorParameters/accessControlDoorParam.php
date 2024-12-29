<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function doorParameters($host)
{
    $url = "https://$host/ISAPI/AccessControl/Door/param/1?security=1&iv=70afca2183976d5a28453cd5edc7f01a";
    $xml = isAPI($url, 'GET');
    if(isset($xml->error)){
        return $xml->error;
    }
    return [
        "doorName" => $xml->doorName,
        "openDuration" => $xml->openDuration,
        "magneticAlarmTimeout" => $xml->magneticAlarmTimeout,
        "magneticType" => $xml->magneticType,
        "openButtonType" => $xml->openButtonType,
        "disabledOpenDuration" => $xml->disabledOpenDuration,
        "leaderCardOpenDuration" => $xml->leaderCardOpenDuration,
    ];
}
function lockTypeStatus($host)
{
    $url = "https://$host/ISAPI/AccessControl/Configuration/lockType?format=json";
    $response = isAPI($url, 'GET');
    if(isset($response->error)){
        return $response->error;
    }
    return $response;
}

echo json_encode([
    "doorParameters" => doorParameters($host),
    "lockTypeStatus" => lockTypeStatus($host),
]);
