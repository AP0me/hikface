<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';


function sendPutRequest($host, $endpoint, $body, $headers = [])
{
  $url = "https://$host/$endpoint";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

  deviceAuth($ch);

  // Set headers
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    curl_close($ch);
    return null;
  }

  // Close cURL session
  curl_close($ch);

  // Return response
  if(isXml($response)) {
    return xmlToJson($response);
  }
  return $response;
}

$reqBody = reqBody();
// Request 1: Card Reader Configuration
$cardReaderCfgBody = json_encode([
  "CardReaderCfg" => json_decode($reqBody['CardReaderCfg']),
]);

$response = sendPutRequest($host, "ISAPI/AccessControl/CardReaderCfg/1?format=json", $cardReaderCfgBody);
echo $response;

// Request 2: Mask Detection
$maskDetectionBody = json_encode([
  "MaskDetection" => json_decode($reqBody['MaskDetection']),
]);
$response = sendPutRequest($host, "ISAPI/AccessControl/maskDetection?format=json", $maskDetectionBody);
echo $response;

// Request 3: Identity Terminal
$IdentityTerminalData = (array)json_decode($reqBody['IdentityTerminal']);
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

$response = sendPutRequest($host, "ISAPI/AccessControl/IdentityTerminal", $identityTerminalBody, [
  "Content-Type: application/xml",
]);
echo json_encode($response);


