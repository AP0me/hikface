<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateSystemTime($host, $xmlBody)
{
  $url = "https://$host/ISAPI/System/time";
  $response = isAPI($url, 'PUT', $xmlBody);
  if(isset($response->error)){
    echo $response->error;
    return null;
  }
  return $response;
}

$reqBody = reqBody();
// XML body to send
$xmlBody = '<?xml version="1.0" encoding="UTF-8"?>'
  . '<Time>'
  . '<timeMode>'.$reqBody['syncMode'].'</timeMode>'
  . '<localTime>'.$reqBody['datetime'].'</localTime>'
  . '<timeZone>'.$reqBody['zone'].'</timeZone>'
  . '</Time>';

// Call the function
echo json_encode(updateSystemTime($host, $xmlBody));
