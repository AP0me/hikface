<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateDeviceInfo($host, $xmlBody, $backURL)
{
  $url = "https://$host/ISAPI/System/deviceInfo";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody); // Set XML body

  $ch = deviceAuth($ch);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    echo "Response: " . $response;
  }

  // Close cURL session
  curl_close($ch);
  header("location: $backURL");
  exit;
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

updateDeviceInfo($host, $xmlBody, $reqBody['backURL']);
