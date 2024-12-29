<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';


function getFaceCompareCond($host)
{
  $url = "https://$host/ISAPI/AccessControl/FaceCompareCond";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  return $response;
}

echo json_encode(getFaceCompareCond($host));
