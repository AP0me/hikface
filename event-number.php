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

  // Set headers
  $headers = [
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0",
    "Accept: */*",
    "Accept-Language: en-US,en;q=0.5",
    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
    "If-Modified-Since: 0",
    "SessionTag: FD7BAAZAVY912N0N1N6EO6BC6YUWGDKE1CW4ETOVGIBQ8JVLO8JK8383YIXQIWDR",
    "X-Requested-With: XMLHttpRequest",
    "Pragma: no-cache",
    "Cache-Control: no-cache",
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

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

