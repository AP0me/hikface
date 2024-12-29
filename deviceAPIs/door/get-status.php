<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchAcsWorkStatus($host)
{
  $url = "https://$host/ISAPI/AccessControl/AcsWorkStatus?format=json";
  $response = isAPI($url, 'GET');
  if(isset($response->error)){
    echo json_encode($response->error);
    return null;
  }
  return $response->AcsWorkStatus->doorStatus[0];
}

$doorStatusNumberMap = [
  4 => 'controlled',
  2 => 'remainOpen',
  3 => 'remainClose',
];
$doorStatus = $doorStatusNumberMap[fetchAcsWorkStatus($host)];
echo json_encode(["doorStatus" => $doorStatus]);
