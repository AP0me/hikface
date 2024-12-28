<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateDeviceId($host, $xmlBody)
{
  $url = "https://$host/ISAPI/VideoIntercom/deviceId";
  return isAPI($url, 'PUT', $xmlBody);
}

$deviceIDs = reqBody()['deviceIDs'];
$unitType = $deviceIDs['deviceType'];
$floorNumber = $deviceIDs['floorNumber'];
$deviceIndex = $deviceIDs['deviceIndex'];
$periodNumber = $deviceIDs['communityNumber'];
$buildingNumber = $deviceIDs['buildingNumber'];
$unitNumber = $deviceIDs['unitNumber'];

$xmlBody = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
  . "<DeviceId version=\"2.0\" xmlns=\"http://www.isapi.org/ver20/XMLSchema\">"
  . "<unitType>$unitType</unitType>"
  . "<periodNumber>$periodNumber</periodNumber>"
  . "<buildingNumber>$buildingNumber</buildingNumber>"
  . "<unitNumber>$unitNumber</unitNumber>"
  . "<floorNumber>$floorNumber</floorNumber>"
  . "<deviceIndex>$deviceIndex</deviceIndex>"
  . "</DeviceId>";

echo json_encode(updateDeviceId($host, $xmlBody));
