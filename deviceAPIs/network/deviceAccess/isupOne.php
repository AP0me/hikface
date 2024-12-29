<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function isupOne($host)
{
    $url = "https://$host/ISAPI/System/Network/Ehome?centerID=1&security=1&iv=a12ef7c7f6a658c60a965d4a060cba4d";
    $response = isAPI($url, 'GET');
    if (isset($response->error)) {
        echo json_encode($response->error);
        return null;
    }
    return [
        "enabled" => $response->enabled ? 'true' : 'false',
        "protocolVersion" => $response->protocolVersion,
        "ipAddress" => $response->ipAddress,
        "portNo" => $response->portNo,
        "deviceID" => $response->deviceID,
        "registerStatus" => $response->registerStatus,
    ];
}
function isupTwo($host)
{
    // URL for the request
    $url = "https://$host/ISAPI/Event/notification/httpHosts?security=1&iv=fe2b15734bdebbaf1ee52324254b3655";
    $response = isAPI($url, 'GET');
    if (isset($response->error)) {
        echo json_encode($response->error);
        return null;
    }
    return [
        "ipAddress" => (string)$response->HttpHostNotification[1]->ipAddress,
        "url" => (string)$response->HttpHostNotification[1]->url,
        "portNo" => (string)$response->HttpHostNotification[1]->portNo,
    ];
}
echo json_encode([
    "isupOne" => isupOne($host),
    "isupTwo" => isupTwo($host),
]);
