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

function deviceAuth($ch)
{
  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
  return $ch;
}

function isAPI($url, $method, $body = null)
{
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
  if($body && (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'TRACE'])))
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

  $ch = deviceAuth($ch);
  $response = curl_exec($ch);
  
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    if (isXml($response)) {
      return xmlToJson($response);
    } else {
      return json_decode($response);
    }
  }
  curl_close($ch);
}


function reqBody()
{
  $rawInput = file_get_contents('php://input');
  $data = json_decode($rawInput, true);
  if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'Invalid JSON payload']);
    die;
  }
  return $data;
}
