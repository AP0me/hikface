<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchSDKLanguage($host)
{
  $url = "https://$host/SDK/language";
  return isAPI($url, "GET")->type;
}

// Example usage
echo json_encode([ 'language' => fetchSDKLanguage($host)]);
