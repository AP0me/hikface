<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function setCommuMode($host, $body)
{
  $url = "https://$host/ISAPI/Security/CommuMode?format=json";
  $reponse = isAPI($url, "PUT", $body);
  if (isset($reponse->error)) {
    return $reponse->error;
  }
  return $reponse;
}


$body = json_encode([
  "CommuMode" => [
    "mode" => reqBody()['mode']
  ]
]);

echo json_encode(setCommuMode($host, $body));