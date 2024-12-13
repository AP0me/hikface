<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
function fetchAcsEventTotalNum($host)
{
  $url = "https://$host/ISAPI/AccessControl/AcsEventTotalNum?format=json";

  // JSON body
  $data = json_encode([
    "AcsEventTotalNumCond" => [
      "major" => 0,
      "minor" => 0
    ]
  ]);

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); // Set method to POST
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Attach the JSON body

  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Execute cURL request
  $response = json_decode(curl_exec($ch));

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    return $response->AcsEventTotalNum->totalNum;
  }

  // Close cURL session
  curl_close($ch);
}

// Example usage

