<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateConfig($host, $endpoint, $payload)
{
  $url = "https://$host/$endpoint";
  $response = isAPI($url, 'PUT', json_encode($payload));
  if (isset($response->error)) {
    return $response->error;
  }
  return (array)$response;
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
