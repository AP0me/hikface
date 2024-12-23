<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function fetchAcsEvent($host)
{
  $url = "https://$host/ISAPI/AccessControl/UserInfo/Count?format=json";


  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for local testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
  
  // Execute cURL request
  $response = json_decode(curl_exec($ch));

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    return $response;
  }
}
echo json_encode(fetchAcsEvent($host));
