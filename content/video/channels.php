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
