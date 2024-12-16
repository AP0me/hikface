<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

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

  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Set default headers
  $defaultHeaders = [
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0",
    "Accept: */*",
    "Accept-Language: en-US,en;q=0.5",
    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
    "If-Modified-Since: 0",
    "X-Requested-With: XMLHttpRequest",
    "Pragma: no-cache",
    "Cache-Control: no-cache",
  ];

  // Merge default and additional headers
  $finalHeaders = array_merge($defaultHeaders, $headers);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $finalHeaders);

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
  return $response;
}

// Example usage
$host = "192.168.0.116";

// Request 1: Card Reader Configuration
$cardReaderCfgBody = json_encode([
  "CardReaderCfg" => [
    "enable" => true,
    "okLedPolarity" => "anode",
    "errorLedPolarity" => "anode",
    "swipeInterval" => 0,
    "enableFailAlarm" => true,
    "maxReadCardFailNum" => 5,
    "pressTimeout" => 10,
    "enableTamperCheck" => true,
    "offlineCheckTime" => 0,
    "fingerPrintCheckLevel" => 5,
    "faceMatchThresholdN" => 90,
    "faceRecogizeTimeOut" => 3,
    "faceRecogizeInterval" => 3,
    "cardReaderFunction" => ["fingerPrint", "face"],
    "cardReaderDescription" => "DS-K1T341CMFW",
    "livingBodyDetect" => true,
    "faceMatchThreshold1" => 60,
    "liveDetLevelSet" => "general",
    "liveDetAntiAttackCntLimit" => 100,
    "enableLiveDetAntiAttack" => true,
    "fingerPrintCapacity" => 3000,
    "fingerPrintNum" => 5,
    "defaultVerifyMode" => "faceOrFpOrCardOrPw",
    "faceRecogizeEnable" => 1,
    "enableReverseCardNo" => true,
    "independSwipeIntervals" => 1,
    "maskFaceMatchThresholdN" => 75,
    "maskFaceMatchThreshold1" => 75,
  ],
]);
$response = sendPutRequest($host, "ISAPI/AccessControl/CardReaderCfg/1?format=json", $cardReaderCfgBody);
echo "Response for CardReaderCfg: <pre>" . htmlspecialchars($response) . "</pre>";

// Request 2: Mask Detection
$maskDetectionBody = json_encode([
  "MaskDetection" => [
    "enable" => true,
    "noMaskStrategy" => "noTipsAndOpenDoor",
  ],
]);
$response = sendPutRequest($host, "ISAPI/AccessControl/maskDetection?format=json", $maskDetectionBody);
echo "Response for MaskDetection: <pre>" . htmlspecialchars($response) . "</pre>";

// Request 3: Identity Terminal
$identityTerminalBody = <<<XML
<IdentityTerminal version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
    <faceAlgorithm>DeepLearn</faceAlgorithm>
    <comNo/>
    <memoryLearning/>
    <saveCertifiedImage>enable</saveCertifiedImage>
    <readInfoOfCard>serialNo</readInfoOfCard>
    <workMode>accessControlMode</workMode>
    <ecoMode>
        <eco>enable</eco>
        <faceMatchThreshold1>60</faceMatchThreshold1>
        <faceMatchThresholdN>80</faceMatchThresholdN>
        <changeThreshold>4</changeThreshold>
        <maskFaceMatchThresholdN>70</maskFaceMatchThresholdN>
        <maskFaceMatchThreshold1>70</maskFaceMatchThreshold1>
    </ecoMode>
    <enableScreenOff>true</enableScreenOff>
    <screenOffTimeout>60</screenOffTimeout>
    <showMode>normal</showMode>
</IdentityTerminal>
XML;
$response = sendPutRequest($host, "ISAPI/AccessControl/IdentityTerminal", $identityTerminalBody, [
  "Content-Type: application/xml",
]);
echo "Response for IdentityTerminal: <pre>" . htmlspecialchars($response) . "</pre>";

// Request 4: Face Compare Condition
$faceCompareCondBody = <<<XML
<FaceCompareCond version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
    <pitch>45</pitch>
    <yaw>45</yaw>
    <leftBorder>5</leftBorder>
    <rightBorder>5</rightBorder>
    <upBorder>0</upBorder>
    <bottomBorder>0</bottomBorder>
    <faceScore>0</faceScore>
    <maxDistance>auto</maxDistance>
</FaceCompareCond>
XML;
$response = sendPutRequest($host, "ISAPI/AccessControl/FaceCompareCond", $faceCompareCondBody, [
  "Content-Type: application/xml",
]);
echo "Response for FaceCompareCond: <pre>" . htmlspecialchars($response) . "</pre>";
