<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateConfig($host, $endpoint, $payload)
{
  $url = "https://$host/$endpoint";

  $jsonBody = json_encode($payload);

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

  $ch = deviceAuth($ch);
  $response = curl_exec($ch);

  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    return null;
  }

  curl_close($ch);

  return json_decode($response, true);
}

// Extract URL parameters
parse_str($_SERVER['QUERY_STRING'], $queryParams);

// Decode parameters
$storageConfigPayload = isset($queryParams['storageConfig']) ? json_decode($queryParams['storageConfig'], true) : null;
$userAndRightShowPayload = isset($queryParams['userAndRightShow']) ? json_decode($queryParams['userAndRightShow'], true) : null;
$acsConfigPayload = isset($queryParams['acsConfig']) ? json_decode($queryParams['acsConfig'], true) : null;

// Example usage
if ($storageConfigPayload) {
  $storageConfigPayload = ["EventStorageCfg" => ["mode" => $storageConfigPayload['mode']]];
  $eventStorageConfig = updateConfig($host, "ISAPI/AccessControl/AcsEvent/StorageCfg?format=json", $storageConfigPayload);
  echo '<pre>Storage Config: ' . json_encode($eventStorageConfig, JSON_PRETTY_PRINT) . '</pre>';
}

if ($userAndRightShowPayload) {
  $userAndRightShowConfig = updateConfig($host, "ISAPI/AccessControl/userAndRightShow?format=json", $userAndRightShowPayload);
  echo '<pre>User and Right Show Config: ' . json_encode($userAndRightShowConfig, JSON_PRETTY_PRINT) . '</pre>';
}

if ($acsConfigPayload) {
  $acsConfig = updateConfig($host, "ISAPI/AccessControl/AcsCfg?format=json", $acsConfigPayload);
  echo '<pre>ACS Config: ' . json_encode($acsConfig, JSON_PRETTY_PRINT) . '</pre>';
}
