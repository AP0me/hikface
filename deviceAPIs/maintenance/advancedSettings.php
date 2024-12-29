<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchNetworkInterfaces($host) {
    $url = "https://$host/ISAPI/AccessControl/EngineeringModeMgr/cardReader/1/ReaderEngineeringModeParams?format=json";
    
    $response = isAPI($url, 'GET');
    if(isset($response->error)){
        echo json_encode($response->error);
        return null;
    }
    return [
        "antiSpoofingDetParams" => [
            "customEnabled" => $response->antiSpoofingDetParams->customEnabled ? 'true' : 'false',
            "antiSpoofingDetLevel" => $response->antiSpoofingDetParams->antiSpoofingDetLevel,
            "antiSpoofingDetThreshold" => $response->antiSpoofingDetParams->antiSpoofingDetThreshold,
            "maskAntiSpoofingDetThreshold" => $response->antiSpoofingDetParams->maskAntiSpoofingDetThreshold,
            "antiAttackEnabled" => $response->antiSpoofingDetParams->antiAttackEnabled ? 'true' : 'false',
            "antiAttackLockTime" => $response->antiSpoofingDetParams->antiAttackLockTime,
        ],
        "readerVersion" => [
            "BSPVersion" => $response->readerVersion->BSPVersion,
            "DSPVersion" => $response->readerVersion->DSPVersion,
            "engineVersion" => $response->readerVersion->engineVersion,
            "faceAlgorithmVersion" => $response->readerVersion->faceAlgorithmVersion,
            "antiSpoofingAlgorithmVersion" => $response->readerVersion->antiSpoofingAlgorithmVersion,
        ]
    ];
}
echo json_encode(fetchNetworkInterfaces($host));
