<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function searchCustomAudioStatus($host)
{
  $url = "https://$host/ISAPI/AccessControl/customAudio/searchCustomAudioStatus?format=json";

  // JSON body for the POST request
  $jsonBody = json_encode([
    "customAudioSearchType" => [
      "callCenter",
      "centerRefused",
      "centerOverTime",
      "callAgain",
      "thanks",
      "verifyFailed",
      "doorOpened",
      "wearMask"
    ]
  ]);

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); // Set method to POST
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody); // Attach JSON body

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
    return null;
  }

  // Close cURL session
  curl_close($ch);

  // Return response
  return $response;
}

$response = searchCustomAudioStatus($host);
echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
