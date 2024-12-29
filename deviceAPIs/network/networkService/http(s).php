<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchNetwork($host)
{
    $url = "https://$host/ISAPI/Event/notification/httpHosts?security=1&iv=ea89e569f0513a02629d6a0419baa843";
    $response = isAPI($url, 'GET');
    if (isset($response->error)) {
        echo json_encode($response->error);
        return null;
    }
    return [
        "ipAddress" => (string)$response->HttpHostNotification->ipAddress,
        "url" => (string)$response->HttpHostNotification->url,
        "portNo" => (string)$response->HttpHostNotification->portNo,
        "protocolType" => (string)$response->HttpHostNotification->protocolType,
    ];
}
function http($host)
{
    $url = "https://$host/ISAPI/Security/adminAccesses";
    $response = isAPI($url, 'GET');
    if (isset($response->error)) {
        echo json_encode($response->error);
        return null;
    }
    $result = [];
    foreach ($response->AdminAccessProtocol as $protocol) {
        $result[] = [
            "id" => $protocol->id,
            "enabled" => $protocol->enabled,
            "protocol" => $protocol->protocol,
            "portNo" => $protocol->portNo,
        ];
    }
    return $result;
}

echo json_encode([
    "http" => http($host),
    "fetchNetwork" => fetchNetwork($host),
]);
