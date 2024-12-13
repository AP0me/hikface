<?php require_once $_SERVER['DOCUMENT_ROOT'].'/hostname.php'; ?>
<?php
function fetchAcsWorkStatus($host)
{
  $url = "https://$host/ISAPI/AccessControl/AcsWorkStatus?format=json";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  }
  else {
    $doorLockStatus = json_decode($response)->AcsWorkStatus;
    return $doorLockStatus->doorStatus[0];
  }

  // Close cURL session
  curl_close($ch);
}

