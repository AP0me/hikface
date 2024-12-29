<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchKeyCapabilities($host)
{
  $url = "https://$host/ISAPI/VideoIntercom/keyCfg/1/capabilities";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo $response->error;
    return null;
  }
  return explode(',', $response->callMethod->{'@attributes'}->opt);
}

function fetchKeyConfig($host)
{
  $url = "https://$host/ISAPI/VideoIntercom/keyCfg";

  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo $response->error;
    return null;
  }
  return $response->KeyCfg->callMethod;
}

echo json_encode([
  "Capabilities" => [
    fetchKeyCapabilities($host)
  ],
  "Configuration" => [
    fetchKeyConfig($host)
  ]
]);

