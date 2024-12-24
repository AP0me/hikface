<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';


function getCommuMode($host)
{
  $url = "https://$host/ISAPI/Security/CommuMode?format=json";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as string
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET

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
  return $response;
}

$response = getCommuMode($host);


$mode = json_decode($response)->CommuMode->mode;
print_r(json_encode([
  'mode' => $mode
]));

