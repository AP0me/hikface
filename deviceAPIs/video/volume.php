<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchAudioVolume($host, $inOut)
{
  $inOutMap = [
    'in' => ['AudioIn', 'AudioInVlome', 'AudioInVolumelist'],
    'out' => ['AudioOut', 'AudioOutVlome', 'AudioOutVolumelist'],
  ];
  $audioInOut = $inOutMap[$inOut][0];
  $url = "https://$host/ISAPI/System/Audio/$audioInOut/channels/1/capabilities";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  $audioInOut = $inOutMap[$inOut][1];
  $audioInOutVolumelist = $inOutMap[$inOut][2];
  $volume = $response->{$audioInOutVolumelist}->{$audioInOut}->volume;
  return $volume;
}

