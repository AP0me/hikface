<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

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

$response = getCommuMode($host);

if ($response) {
  echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
} else {
  echo "Failed to fetch communication mode.";
}

$mode = json_decode($response)->CommuMode->mode;
?>


<a href="security-save.php?mode=<?= htmlspecialchars($mode); ?>">
  <button>Save</button>
</a>