<?php
function xmlToJson($reponseXML)
{
  return json_decode(json_encode(new SimpleXMLElement($reponseXML)));
}

function isXml($xml)
{
  libxml_use_internal_errors(true);
  $xml = simplexml_load_string($xml);
  libxml_clear_errors();
  return $xml !== false;
}

function isAPIGet($url)
{
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
  } else {
    if (isXml($response)) {
      return xmlToJson($response);
    } else {
      return json_decode($response);
    }
  }

  // Close cURL session
  curl_close($ch);
}


function reqBody(){
  $rawInput = file_get_contents('php://input');
  $data = json_decode($rawInput, true);
  if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'Invalid JSON payload']);
    die;
  }
  return $data;
}
