<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchSDKLanguage($host)
{
  $url = "https://$host/SDK/language";
  $response = isAPI($url, 'GET');
  if(isset($response->error)){
    echo json_encode($response->error);
    return null;
  }
  return $response->type;
}

// Example usage
echo json_encode([ 'language' => fetchSDKLanguage($host)]);
