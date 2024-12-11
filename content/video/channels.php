<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';
function streamingChannels($host)
{
  // Initialize a cURL session
  $ch = curl_init();

  // Set the URL
  $url = "https://$host/ISAPI/Streaming/channels";
  curl_setopt($ch, CURLOPT_URL, $url);

  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Set the HTTP headers
  $headers = [
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0",
    "Accept: */*",
    "Accept-Language: en-US,en;q=0.5",
    "If-Modified-Since: 0",
    "SessionTag: XNNO0FQPRGUKEYYLNHWISFWTC1FL2TNZ05UB21FSRDWT23B7PFEUZKZ0561IH4OG",
    "X-Requested-With: XMLHttpRequest",
    "Sec-Fetch-Dest: empty",
    "Sec-Fetch-Mode: cors",
    "Sec-Fetch-Site: same-origin",
    "Pragma: no-cache",
    "Cache-Control: no-cache"
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Include credentials (cookies, session, etc.)
  curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
  curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");

  // Set the referrer
  curl_setopt($ch, CURLOPT_REFERER, "https://192.168.0.116/doc/index.html");

  // Set the request method to GET
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

  // Enable return transfer to capture the response
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  // Disable SSL verification for self-signed certificates (not recommended for production)
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  // Execute the request and capture the response
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
  } else {
    // Print the response
    return xmlToJson($response)->StreamingChannel;
  }

  // Close the cURL session
  curl_close($ch);
}
