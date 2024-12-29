<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';


function updateAudioIn($host, $xmlBody)
{
  $url = "https://$host/ISAPI/System/Audio/AudioIn/channels/1";
  $response = isAPI($url, 'PUT', $xmlBody);
  if(isset($response->error)){
    echo json_encode($response->error);
    return null;
  }
  return $response;
}

function updateAudioOut($host, $xmlBody)
{
  $url = "https://$host/ISAPI/System/Audio/AudioOut/channels/1";
  $response = isAPI($url, 'PUT', $xmlBody);
  if(isset($response->error)){
    echo json_encode($response->error);
    return null;
  }
  return $response;
}

$mainAudioStream = reqBody()['mainAudioStream'];
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


echo json_encode([
  "updateAudioIn" => updateAudioIn($host, $audioInXml),
  "updateAudioOut" => updateAudioOut($host, $audioOutXml),
]);
