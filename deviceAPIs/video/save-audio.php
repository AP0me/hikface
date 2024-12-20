<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';


function updateAudioIn($host, $xmlBody)
{
  $url = "https://$host/ISAPI/System/Audio/AudioIn/channels/1";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody); // Set XML body

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
    return xmlToJson($response);
  }

  // Close cURL session
  curl_close($ch);
}

function updateAudioOut($host, $xmlBody)
{
  $url = "https://$host/ISAPI/System/Audio/AudioOut/channels/1";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody); // Set XML body

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
    return xmlToJson($response);
  }

  // Close cURL session
  curl_close($ch);
}

$mainAudioStream = json_decode($_GET['mainAudioStream']);
$inputVolume = $mainAudioStream->inputVolume;
$outputVolume = $mainAudioStream->outputVolume;
$audioInputChannelID = $mainAudioStream->audioInputChannelID;

$audioInXml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
  . "<AudioIn>"
  . "<id>$audioInputChannelID</id>"
  . "<AudioInVolumelist>"
  . "<AudioInVlome>"
  . "<type>audioInput</type>"
  . "<volume>$inputVolume</volume>"
  . "</AudioInVlome>"
  . "</AudioInVolumelist>"
  . "<audioInCodingFormat/>"
  . "</AudioIn>";

$audioOutXml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
  . "<AudioOut>"
  . "<id>$audioInputChannelID</id>"
  . "<AudioOutVolumelist>"
  . "<AudioOutVlome>"
  . "<type>audioOutput</type>"
  . "<volume>$outputVolume</volume>"
  . "</AudioOutVlome>"
  . "</AudioOutVolumelist>"
  . "</AudioOut>";

echo json_encode(updateAudioIn($host, $audioInXml));
echo json_encode(updateAudioOut($host, $audioOutXml));
