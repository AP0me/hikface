<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function setCommuMode($host, $body)
{
  $url = "https://$host/ISAPI/Security/CommuMode?format=json";
  return isAPI($url, 'PUT', $body);
}


$body = json_encode([
  "CommuMode" => [
    "mode" => reqBody()['mode']
  ]
]);

$response = setCommuMode($host, $body);
echo $response;
