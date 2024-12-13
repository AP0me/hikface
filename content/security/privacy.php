<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function fetchStorageConfig($host)
{
  $url = "https://$host/ISAPI/AccessControl/AcsEvent/StorageCfg?format=json";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
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

  // Decode and return the JSON response
  return json_decode($response, true)['EventStorageCfg'];
}

// Example usage
$storageConfig = fetchStorageConfig($host);

if ($storageConfig) {
  echo '<pre>' . json_encode($storageConfig, JSON_PRETTY_PRINT) . '</pre>';
} else {
  echo "Failed to fetch storage configuration.";
}


function fetchUserAndRightShow($host)
{
  $url = "https://$host/ISAPI/AccessControl/userAndRightShow?format=json";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
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

  // Decode and return the JSON response
  return json_decode($response, true);
}

// Example usage
$userAndRightShow = fetchUserAndRightShow($host);

if ($userAndRightShow) {
  echo '<pre>' . json_encode($userAndRightShow, JSON_PRETTY_PRINT) . '</pre>';
} else {
  echo "Failed to fetch user and right show data.";
}


function fetchAcsConfig($host)
{
  $url = "https://$host/ISAPI/AccessControl/AcsCfg?format=json";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
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

  // Decode and return the JSON response
  return json_decode($response, true);
}

// Example usage
$acsConfig = fetchAcsConfig($host);

if ($acsConfig) {
  echo '<pre>' . json_encode($acsConfig, JSON_PRETTY_PRINT) . '</pre>';
} else {
  echo "Failed to fetch ACS configuration.";
}
?>


<br><br>
<a href="privacy-save.php?storageConfig=<?= htmlspecialchars(json_encode($storageConfig)); ?>&userAndRightShow=<?= htmlspecialchars(json_encode($userAndRightShow)); ?>&acsConfig=<?= htmlspecialchars(json_encode($acsConfig)); ?>">
  <button>Save</button>
</a>