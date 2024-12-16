<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateRelatedDeviceAddress($host, $xmlBody)
{
  $url = "https://$host/ISAPI/VideoIntercom/relatedDeviceAddress";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody); // Set XML body

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
    echo "Response: " . $response;
  }

  // Close cURL session
  curl_close($ch);
}

$linkedNetwork = json_decode($_GET['linkedNetwork']);
$deviceType = $linkedNetwork->deviceType;
$serverIPAddress = $linkedNetwork->serverIPAddress;
$stationIPAddress = $linkedNetwork->stationIPAddress;

$xmlBody = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
  . "<RelatedDeviceAddress version=\"2.0\" xmlns=\"http://www.isapi.org/ver20/XMLSchema\">"
  . "<SIPServerAddress>"
  . "<addressingFormatType>ipaddress</addressingFormatType>"
  . "<ipAddress>0.0.0.0</ipAddress>"
  . "</SIPServerAddress>"
  . "<ManageAddress>"
  . "<addressingFormatType>ipaddress</addressingFormatType>"
  . "<ipAddress>0.0.0.0</ipAddress>"
  . "</ManageAddress>"
  . "</RelatedDeviceAddress>";

updateRelatedDeviceAddress($host, $xmlBody);
