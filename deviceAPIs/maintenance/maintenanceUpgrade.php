<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function upgrade($host)
{
    $url = "https://$host/ISAPI/System/upgradeStatus";
    $response = isAPI($url, 'GET');
    if (isset($response->error)) {
        echo json_encode($response->error);
        return null;
    }
    return $response;
}

function vers($host)
{
    $url = "https://$host/ISAPI/System/onlineUpgrade/version?check=true";
    $response = isAPI($url, 'GET');
    if (isset($response->error)) {
        echo json_encode($response->error);
        return null;
    }
    return $response;
}

echo json_encode([
    "upgrade" => upgrade($host),
    "vers" => vers($host),
]);
