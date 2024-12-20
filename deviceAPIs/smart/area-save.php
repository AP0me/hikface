<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function updateFaceCompareCond($host)
{
  $url = "https://$host/ISAPI/AccessControl/FaceCompareCond";

  // XML body
  $xmlBody = <<<XML
<FaceCompareCond version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
    <pitch>45</pitch>
    <yaw>45</yaw>
    <leftBorder>5</leftBorder>
    <rightBorder>5</rightBorder>
    <upBorder>0</upBorder>
    <bottomBorder>0</bottomBorder>
    <faceScore>0</faceScore>
    <maxDistance>auto</maxDistance>
</FaceCompareCond>
XML;

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody); // Attach XML body

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

$response = updateFaceCompareCond($host);
echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
