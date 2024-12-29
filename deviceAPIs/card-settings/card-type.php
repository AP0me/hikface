<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchRFCardConfiguration($host)
{
  $url = "https://$host/ISAPI/AccessControl/Configuration/RFCardCfg?format=json";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  return $response;
}

$RFCardCfg = fetchRFCardConfiguration($host)->RFCardCfg;

echo json_encode($RFCardCfg);
