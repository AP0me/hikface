<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function http($host)
{
    $url = "https://$host/ISAPI/Security/adminAccesses";
    $response = isAPI($url, 'GET');
    if (isset($response->error)) {
        echo json_encode($response->error);
        return null;
    }
    return [
        "version" => $response['version'],
        "portNo" => $response->AdminAccessProtocol[1]->portNo,
    ];
}
echo json_encode(http($host));
