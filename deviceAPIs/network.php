<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';


function fetchNetworkInterfaces($host)
{
    $url = "https://$host/ISAPI/System/Network/interfaces";
    $response = isAPI($url, 'GET');

    if(isset($reponse->error)){
        echo json_encode($response->error);
        return null;
    }
    return $response;
}

// Example usage
echo json_encode(fetchNetworkInterfaces($host));
