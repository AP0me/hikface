<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchNetworkInterfaces($host)
{
    $url = "https://$host/ISAPI/AccessControl/WiegandCfg/wiegandNo/1";
    $response = isAPI($url, 'GET');
    if(isset($response->error)){
        echo json_encode($response->error);
        return null;
    }
    if ($response->enable == 'true') {
        return [
            "enable" => $response->enable,
            "communicateDirection" => $response->communicateDirection,
            "wiegandMode" => $response->wiegandMode,
        ];
    } else {
        return ["enable" => $response->enable, "communicateDirection" => 0, "wiegandMode" => 0,];
    }
}
echo json_encode(fetchNetworkInterfaces($host));
