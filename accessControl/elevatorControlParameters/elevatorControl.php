<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function elevatorControlParameter($host)
{
    $url = "https://$host/ISAPI/VideoIntercom/Elevators/1/ControlCfg?format=json&security=1&iv=6b5633d7e91a7bff94e5465fd6be8f5d";
    $response = isAPI($url, 'GET');
    if(isset($response->error)){
        return $response->error;
    }
    
    return [
        "interfaceType" => $response->ElevatorControlCfg->interfaceType==1?'RS-485':'Network İnterface',
        "enable" => $response->ElevatorControlCfg->enable,
        "deviceType" => $response->ElevatorControlCfg->deviceType,
        "numOfNegFloors" => $response->ElevatorControlCfg->numOfNegFloors,
        "ipAddress" => $response->ElevatorControlCfg->ServerAddress->ipAddress,
        "serverPort" => $response->ElevatorControlCfg->serverPort,
    ];
}
echo json_encode(elevatorControlParameter($host));
