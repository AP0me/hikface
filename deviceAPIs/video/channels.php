<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';
function streamingChannels($host)
{
  // Initialize a cURL session
  $ch = curl_init();

  // Set the URL
  $url = "https://$host/ISAPI/Streaming/channels";
  $response = isAPI($url, "GET");
  if(isset($reponse->error)){
    echo json_encode($response->error);
    return null;
  }
  return $response;
}

