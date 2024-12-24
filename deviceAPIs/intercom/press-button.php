<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchKeyCapabilities($host)
{
  $url = "https://$host/ISAPI/VideoIntercom/keyCfg/1/capabilities";

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
  } else {
    return explode(',', xmlToJson($response)->callMethod->{'@attributes'}->opt);
  }

  // Close cURL session
  curl_close($ch);
}

function fetchKeyConfig($host)
{
  $url = "https://$host/ISAPI/VideoIntercom/keyCfg";

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
  } else {
    return xmlToJson($response)->KeyCfg->callMethod;
  }

  // Close cURL session
  curl_close($ch);
}

echo json_encode([
  "Capabilities" => [
    fetchKeyCapabilities($host)
  ],
  "Configuration" => [
    fetchKeyConfig($host)
  ]
  ]);

?>

<!-- <br><br>
<a href="press-button-save.php?callMethod=<?= htmlspecialchars(json_encode($callMethod)); ?>">
  <button>Save</button>
</a> -->
