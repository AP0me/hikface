<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function enableSSH($host, $xmlBody)
{
  $url = "https://$host/ISAPI/System/Network/ssh";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody); // Send XML data

  $ch = deviceAuth($ch);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    return null;
  }

  // Close cURL session
  curl_close($ch);

  // Return response
  return xmlToJson($response);
}


// XML Body
$ssh_enabled = reqBody()['enabled'];
$xmlBody = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<SSH>
  <enabled>$ssh_enabled</enabled>
</SSH>
XML;
$response = enableSSH($host, $xmlBody);
echo json_encode($response);
