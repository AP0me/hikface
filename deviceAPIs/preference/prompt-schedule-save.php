<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateTTSText($host)
{
  $url = "https://$host/ISAPI/AccessControl/Verification/ttsText?format=json";

  // JSON body
  $jsonBody = reqBody()['ttsText'];
  $response = isAPI($url, 'PUT', $jsonBody);
  if (isset($response->error)) {
    return $response->error;
  }
  return $response;
}

$response = json_encode(updateTTSText($host));
echo $response;

