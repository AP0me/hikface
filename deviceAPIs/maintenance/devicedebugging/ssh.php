<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function ssh($host) {
    $url = "https://$host/ISAPI/System/Network/ssh";
    $response = isAPI($url, 'GET');
    if (isset($response->error)) {
        echo json_encode($response->error);
        return null;
    }
    return $response;
}
echo json_encode(ssh($host));