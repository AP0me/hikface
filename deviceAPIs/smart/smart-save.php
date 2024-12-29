<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';


function sendPutRequest($host, $endpoint, $body)
{
  $url = "https://$host/$endpoint";
  $response = isAPI($url, "PUT", $body);
  if (isset($response->error)) {
    echo $response->error;
    return null;
  }
  return $response;
}

$reqBody = reqBody();
// Request 1: Card Reader Configuration
$cardReaderCfgBody = json_encode([
  "CardReaderCfg" => $reqBody['CardReaderCfg'],
]);

$CardReaderCfg = sendPutRequest($host, "ISAPI/AccessControl/CardReaderCfg/1?format=json", $cardReaderCfgBody);

// Request 2: Mask Detection
$maskDetectionBody = json_encode([
  "MaskDetection" => $reqBody['MaskDetection'],
]);
$maskDetection = sendPutRequest($host, "ISAPI/AccessControl/maskDetection?format=json", $maskDetectionBody);

// Request 3: Identity Terminal
$IdentityTerminalData = (array)$reqBody['IdentityTerminal'];
$faceAlgorithm = $IdentityTerminalData['faceAlgorithm'];
$saveCertifiedImage = $IdentityTerminalData['saveCertifiedImage'];
$readInfoOfCard = $IdentityTerminalData['readInfoOfCard'];
$workMode = $IdentityTerminalData['workMode'];
$eco = $IdentityTerminalData['eco'];
$faceMatchThreshold1 = $IdentityTerminalData['faceMatchThreshold1'];
$faceMatchThresholdN = $IdentityTerminalData['faceMatchThresholdN'];
$changeThreshold = $IdentityTerminalData['changeThreshold'];
$maskFaceMatchThresholdN = $IdentityTerminalData['maskFaceMatchThresholdN'];
$maskFaceMatchThreshold1 = $IdentityTerminalData['maskFaceMatchThreshold1'];
$enableScreenOff = $IdentityTerminalData['enableScreenOff'];
$screenOffTimeout = $IdentityTerminalData['screenOffTimeout'];
$showMode = $IdentityTerminalData['showMode'];
$identityTerminalBody = <<<XML
<IdentityTerminal version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
    <faceAlgorithm>$faceAlgorithm</faceAlgorithm>
    <comNo/>
    <memoryLearning/>
    <saveCertifiedImage>$saveCertifiedImage</saveCertifiedImage>
    <readInfoOfCard>$readInfoOfCard</readInfoOfCard>
    <workMode>$workMode</workMode>
    <ecoMode>
        <eco>$eco</eco>
        <faceMatchThreshold1>$faceMatchThreshold1</faceMatchThreshold1>
        <faceMatchThresholdN>$faceMatchThresholdN</faceMatchThresholdN>
        <changeThreshold>$changeThreshold</changeThreshold>
        <maskFaceMatchThresholdN>$maskFaceMatchThresholdN</maskFaceMatchThresholdN>
        <maskFaceMatchThreshold1>$maskFaceMatchThreshold1</maskFaceMatchThreshold1>
    </ecoMode>
    <enableScreenOff>$enableScreenOff</enableScreenOff>
    <screenOffTimeout>$screenOffTimeout</screenOffTimeout>
    <showMode>$showMode</showMode>
</IdentityTerminal>
XML;

$IdentityTerminal = sendPutRequest($host, "ISAPI/AccessControl/IdentityTerminal", $identityTerminalBody);


echo json_encode([
  "CardReaderCfg" => $CardReaderCfg,
  "maskDetection" => $maskDetection,
  "IdentityTerminal" => $IdentityTerminal,
]);