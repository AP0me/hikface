<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

class ScreenDisplayPreference
{
  public bool $sleep;
  public int $sleepAfter;
  public string $themeMode;
  public function __construct(
    $sleep,
    $sleepAfter,
    $themeMode,
  ) {
    $this->sleep = $sleep;
    $this->sleepAfter = $sleepAfter;
    $this->themeMode = $themeMode;
  }
}

function fetchIdentityTerminal($host)
{
  $url = "https://$host/ISAPI/AccessControl/IdentityTerminal";

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
  return xmlToJson($response);
}

// Example usage
$identityTerminal = fetchIdentityTerminal($host);
$screenDisplayPreference = new ScreenDisplayPreference(
  $identityTerminal->enableScreenOff,
  $identityTerminal->screenOffTimeout,
  $identityTerminal->showMode,
);

if ($identityTerminal) {
  echo json_encode($screenDisplayPreference, JSON_PRETTY_PRINT);
} else {
  echo "Failed to fetch Identity Terminal data.";
}
?>


