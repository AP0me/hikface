<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';


function sendGetRequest($host, $endpoint, $headers = [])
{
  $url = "https://$host/$endpoint";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Set default headers
  $defaultHeaders = [
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0",
    "Accept: */*",
    "Accept-Language: en-US,en;q=0.5",
    "If-Modified-Since: 0",
    "X-Requested-With: XMLHttpRequest",
    "Pragma: no-cache",
    "Cache-Control: no-cache",
  ];

  // Merge default and additional headers
  $finalHeaders = array_merge($defaultHeaders, $headers);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $finalHeaders);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    curl_close($ch);
    return null;
  }

  // Close cURL session
  curl_close($ch);

  // Return response
  if(isXml($response)){
    return xmlToJson($response);
  }
  else{
    return json_decode($response);
  }
}

// Request for Card Reader Engineering Mode Params
$endpoint = "ISAPI/AccessControl/EngineeringModeMgr/cardReader/1/ReaderEngineeringModeParams?format=json";
$response = sendGetRequest($host, $endpoint);
echo json_encode($response);


$endpoint = "ISAPI/AccessControl/CardReaderCfg/1?format=json";
$response = sendGetRequest($host, $endpoint);
echo json_encode($response);


$endpoint = "ISAPI/AccessControl/maskDetection?format=json";
$response = sendGetRequest($host, $endpoint);
echo json_encode($response);


$endpoint = "ISAPI/AccessControl/IdentityTerminal";
$response = sendGetRequest($host, $endpoint);
echo json_encode($response);


$endpoint = "ISAPI/AccessControl/FaceCompareCond";
$response = sendGetRequest($host, $endpoint);
echo json_encode($response);

