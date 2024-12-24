<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchPwMgrParams($host)
{
  $url = "https://$host/ISAPI/AccessControl/UserAndRight/PwMgrParams?format=json";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
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

  // Decode and return the JSON response
  return json_decode($response, true);
}

// Example usage
$pwMgrParams = fetchPwMgrParams($host);

if ($pwMgrParams) {
  echo json_encode($pwMgrParams);
} else {
  echo "Failed to fetch Password Manager Parameters.";
}
?>
