<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

class SystemTime
{
  public $datetime;
  public $zone;
  public $syncMode;
  public function __construct($datetime, $zone, $syncMode) {
    $this->datetime = $datetime;
    $this->zone = $zone;
    $this->syncMode = $syncMode;
  }
}
function fetchSystemTime($host)
{
  $url = "https://$host/ISAPI/System/time";

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

  // Set headers
  $headers = [
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0",
    "Accept: */*",
    "Accept-Language: en-US,en;q=0.5",
    "If-Modified-Since: 0",
    "SessionTag: VQ83QPI70ZS9J62WL256NI3S595SOAM9OBTKG9VKI2P8KBRDWLKZ7WMRZ2FLJWSZ",
    "X-Requested-With: XMLHttpRequest",
    "Sec-Fetch-Dest: empty",
    "Sec-Fetch-Mode: cors",
    "Sec-Fetch-Site: same-origin",
    "Pragma: no-cache",
    "Cache-Control: no-cache",
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    return xmlToJson($response);
  }

  // Close cURL session
  curl_close($ch);
}

$timeData = fetchSystemTime($host);
$systemTime = new SystemTime(
  $timeData->localTime,
  $timeData->timeZone,
  $timeData->timeMode
);
foreach ($systemTime as $key => $value) {
  print_r($key . ": " . $value . "<br>");
}


