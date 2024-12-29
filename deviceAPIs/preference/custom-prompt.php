<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function searchCustomAudioStatus($host)
{
  $url = "https://$host/ISAPI/AccessControl/customAudio/searchCustomAudioStatus?format=json";
  
  $jsonBody = json_encode([
    "customAudioSearchType" => [
      "callCenter",
      "centerRefused",
      "centerOverTime",
      "callAgain",
      "thanks",
      "verifyFailed",
      "doorOpened",
      "wearMask"
    ]
  ]);
  $response = isAPI($url, 'POST', $jsonBody);
  if(isset($response->error)){
    return $response->error;
  }
  return $response;
}

echo json_encode(searchCustomAudioStatus($host));
