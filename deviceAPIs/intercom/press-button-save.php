<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateKeyConfiguration($host, $xmlBody)
{
  $url = "https://$host/ISAPI/VideoIntercom/keyCfg/1";

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
    return xmlToJson($response);
  }

  // Close cURL session
  curl_close($ch);
}

$callMethod = reqBody()['callMethod'];

$xmlBody = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
  . "<KeyCfg version=\"2.0\" xmlns=\"http://www.isapi.org/ver20/XMLSchema\">"
  . "<id>1</id>"
  . "<enableCallCenter>false</enableCallCenter>"
  . "<callMethod>$callMethod</callMethod>"
  . "</KeyCfg>";

echo json_encode(updateKeyConfiguration($host, $xmlBody));

// header("Location: press-button.php");
