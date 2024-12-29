<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchNetworkInterfaces($host) {
    $url = "https://$host/ISAPI/System/Network/EZVIZ?security=1&iv=8ae15bdec0f9bbec7f0157bd53a29370";
    $response = isAPI($url, 'GET');
    if(isset($response->error)){
        echo json_encode($response->error);
        return null;
    }
    $result = [
        "enabled" => $response->enabled ? 'true' : 'false',
        "serverAddress" => [
            "hostName" => $response->serverAddress->hostName,
        ],
        "verificationCode" => $response->verificationCode,
        "streamEncrypteEnabled" => $response->streamEncrypteEnabled ? 'true' : 'false',
        "NetworkPriorityList" => [
            "NetworkPriority" => [

            ]
        ]
    ];
    for ($i=0; $i < count($response->NetworkPriorityList->NetworkPriority); $i++) {
        $result['NetworkPriorityList']['NetworkPriority'][] = [
            "networkType" => (string)$response->NetworkPriorityList->NetworkPriority[$i]->networkType,
            "priority" => (string)$response->NetworkPriorityList->NetworkPriority[$i]->priority,
        ];
    }
    return $result;
}
echo json_encode(fetchNetworkInterfaces($host));

