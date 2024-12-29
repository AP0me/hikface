<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateDeviceInfo($host, $xmlBody)
{
  $url = "https://$host/ISAPI/System/deviceInfo";
  $response = isAPI($url, 'PUT', $xmlBody);
  if(isset($response->error)){
    echo json_encode($response->error);
    return null;
  }
  return $response;
}

$reqBody = reqBody();
// XML body to send
$xmlBody = '<?xml version="1.0" encoding="UTF-8"?>'
  . '<DeviceInfo version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">'
  . '<deviceName>'.$reqBody['device_name'].'</deviceName>'
  . '<deviceID>255</deviceID>'
  . '<model>DS-K1T341CMFW</model>'
  . '<serialNumber>DS-K1T341CMFW20230901V030315ENFH3990937</serialNumber>'
  . '<macAddress>04:03:12:33:56:36</macAddress>'
  . '<firmwareVersion>V3.3.15</firmwareVersion>'
  . '<firmwareReleasedDate>build 230901</firmwareReleasedDate>'
  . '<encoderVersion>V2.8</encoderVersion>'
  . '<encoderReleasedDate>build 230901</encoderReleasedDate>'
  . '<deviceType>ACS</deviceType>'
  . '<subDeviceType>accessControlTerminal</subDeviceType>'
  . '<telecontrolID>1</telecontrolID>'
  . '<localZoneNum>0</localZoneNum>'
  . '<alarmOutNum>0</alarmOutNum>'
  . '<electroLockNum>1</electroLockNum>'
  . '<RS485Num>1</RS485Num>'
  . '<manufacturer>hikvision</manufacturer>'
  . '<OEMCode>1</OEMCode>'
  . '<bspVersion>v0.0.0 build 2023-7-5</bspVersion>'
  . '<dspVersion>V2.8</dspVersion>'
  . '<marketType>2</marketType>'
  . '<productionDate>2024-07-12</productionDate>'
  . '</DeviceInfo>';

// Call the function

echo json_encode(updateDeviceInfo($host, $xmlBody));
