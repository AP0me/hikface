<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
function updateSystemTime($host, $xmlBody)
{
  $url = "https://$host/ISAPI/System/time";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody); // Set XML body

  // Set headers
  $headers = [
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0",
    "Accept: */*",
    "Accept-Language: en-US,en;q=0.5",
    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
    "If-Modified-Since: 0",
    "SessionTag: E7DY2UL5OF4J2NCRDNL1M06MMI3SGI37TCAMC49D73KXVXLSZE4Y5Z3NTL2Q76GM",
    "X-Requested-With: XMLHttpRequest",
    "Sec-Fetch-Dest: empty",
    "Sec-Fetch-Mode: cors",
    "Sec-Fetch-Site: same-origin",
    "Priority: u=0",
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
    echo "Response: " . $response;
  }

  // Close cURL session
  curl_close($ch);
}

// XML body to send
$xmlBody = '<?xml version="1.0" encoding="UTF-8"?>'
  . '<Time>'
  . '<timeMode>'.$_GET['syncMode'].'</timeMode>'
  . '<localTime>'.$_GET['datetime'].'</localTime>'
  . '<timeZone>'.$_GET['zone'].'</timeZone>'
  . '</Time>';

// Call the function
updateSystemTime($host, $xmlBody);
