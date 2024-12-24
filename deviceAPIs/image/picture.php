<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function imageSetting($host)
{
  $url = "https://$host/ISAPI/Image/channels/1";
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET
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
    $xml = xmlToJson($response);
    return json_encode([
        'brightnessLevel' => $xml->Color->brightnessLevel,
        'contrastLevel' => $xml->Color->contrastLevel,
        'saturationLevel' => $xml->Color->saturationLevel,
        'SharpnessLevel' => $xml->Sharpness->SharpnessLevel,
        'mode' => $xml->WDR->mode,
        'powerLineFrequencyMode' => $xml->powerLineFrequency->powerLineFrequencyMode,
        'enabled' => $xml->Beauty->enabled,
        'whiteningStrength' => $xml->Beauty->whiteningStrength,
        'skinSmoothingStrength' => $xml->Beauty->skinSmoothingStrength,
      ]
    );
  }

  // Close cURL session
  curl_close($ch);
}
echo imageSetting($host);

function LED($a, $host)
{
  $url = "https://$host/ISAPI/Image/channels/$a/supplementLight";
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
    $xml = new SimpleXMLElement($response);
    print_r($xml);
    echo '<br>';
  }

  // Close cURL session
  curl_close($ch);
}
LED('1', $host);
LED('2', $host);
