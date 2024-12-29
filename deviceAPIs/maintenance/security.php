<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';


function getCommuMode($host)
{
  $url = "https://$host/ISAPI/Security/CommuMode?format=json";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  return $response;
}

$response = getCommuMode($host);
$mode = $response->CommuMode->mode;
echo json_encode([
  'mode' => $mode
]);
