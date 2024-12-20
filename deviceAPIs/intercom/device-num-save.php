<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateDeviceId($host, $xmlBody)
{
  $url = "https://$host/ISAPI/VideoIntercom/deviceId";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody); // Set XML body

  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    return xmlToJson($response);
  }

  // Close cURL session
  curl_close($ch);
}

$deviceIDs = json_decode($_GET['deviceIDs']);
$unitType = $deviceIDs->deviceType;
$floorNumber = $deviceIDs->floorNumber;
$deviceIndex = $deviceIDs->deviceIndex;
$periodNumber = $deviceIDs->communityNumber;
$buildingNumber = $deviceIDs->buildingNumber;
$unitNumber = $deviceIDs->unitNumber;

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
