<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function imageSetting($host)
{
  $url = "https://$host/ISAPI/Image/channels/1";
  $response = isAPI($url, 'GET');
  if(isset($response->error)){
    echo $response->error;
    return null;
  }
  return [
    'brightnessLevel' => $response->Color->brightnessLevel,
    'contrastLevel' => $response->Color->contrastLevel,
    'saturationLevel' => $response->Color->saturationLevel,
    'SharpnessLevel' => $response->Sharpness->SharpnessLevel,
    'mode' => $response->WDR->mode,
    'powerLineFrequencyMode' => $response->powerLineFrequency->powerLineFrequencyMode,
    'enabled' => $response->Beauty->enabled,
    'whiteningStrength' => $response->Beauty->whiteningStrength,
    'skinSmoothingStrength' => $response->Beauty->skinSmoothingStrength,
  ];
}

function LED($a, $host)
{
  $url = "https://$host/ISAPI/Image/channels/$a/supplementLight";
  $response = isAPI($url, 'GET');
  if(isset($response->error)){
    echo $response->error;
    return null;
  }
  return $response;
}

echo json_encode([
  "imageSetting" => imageSetting($host),
  "LED1" => LED('1', $host),
  "LED2" => LED('2', $host),
]);
