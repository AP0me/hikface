<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchStorageConfig($host)
{
  $url = "https://$host/ISAPI/AccessControl/AcsEvent/StorageCfg?format=json";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  return $response->EventStorageCfg;
}

// Example usage
$storageConfig = fetchStorageConfig($host);

function fetchUserAndRightShow($host)
{
  $url = "https://$host/ISAPI/AccessControl/userAndRightShow?format=json";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  return $response;
}

$userAndRightShow = fetchUserAndRightShow($host);

function fetchAcsConfig($host)
{
  $url = "https://$host/ISAPI/AccessControl/AcsCfg?format=json";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  return $response;
}

// Example usage
$acsConfig = fetchAcsConfig($host);

echo json_encode([
  'storageConfig' => $storageConfig,
  'userAndRightShow' => $userAndRightShow,
  'acsConfig' => $acsConfig
]);

