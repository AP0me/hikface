<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateRelatedDeviceAddress($host, $xmlBody)
{
  $url = "https://$host/ISAPI/VideoIntercom/relatedDeviceAddress";
  return isAPI($url, 'PUT', $xmlBody);
}

$linkedNetwork = reqBody()['linkedNetwork'];
$serverIPAddress = implode('.', $linkedNetwork['serverIPAddress']);
$stationIPAddress = implode('.', $linkedNetwork['stationIPAddress']);

$xmlBody = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
  . "<RelatedDeviceAddress version=\"2.0\" xmlns=\"http://www.isapi.org/ver20/XMLSchema\">"
  . "<SIPServerAddress>"
  . "<addressingFormatType>ipaddress</addressingFormatType>"
  . "<ipAddress>$serverIPAddress</ipAddress>"
  . "</SIPServerAddress>"
  . "<ManageAddress>"
  . "<addressingFormatType>ipaddress</addressingFormatType>"
  . "<ipAddress>$stationIPAddress</ipAddress>"
  . "</ManageAddress>"
  . "</RelatedDeviceAddress>";

echo json_encode(updateRelatedDeviceAddress($host, $xmlBody));
