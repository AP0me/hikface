<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchAcsEvent($host)
{
  $url = "https://$host/ISAPI/AccessControl/UserInfo/Count?format=json";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  return $response;
}
echo json_encode(fetchAcsEvent($host));
