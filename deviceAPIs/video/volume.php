<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function fetchAudioVolume($host, $inOut)
{
  $inOutMap = [
    'in' => ['AudioIn', 'AudioInVlome', 'AudioInVolumelist'],
    'out' => ['AudioOut', 'AudioOutVlome', 'AudioOutVolumelist'],
  ];
  $audioInOut = $inOutMap[$inOut][0];
  $url = "https://$host/ISAPI/System/Audio/$audioInOut/channels/1/capabilities";

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

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    $xml = xmlToJson($response);
    $audioInOut = $inOutMap[$inOut][1];
    $audioInOutVolumelist = $inOutMap[$inOut][2];
    $volume = $xml->{$audioInOutVolumelist}->{$audioInOut}->volume;
    return $volume;
  }

  // Close cURL session
  curl_close($ch);
}

