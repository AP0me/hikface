<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';


function sendGetRequest($host, $endpoint)
{
  $url = "https://$host/$endpoint";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  return $response;
}

$responseList = [];
// Request for Card Reader Engineering Mode Params
$endpoint = "ISAPI/AccessControl/EngineeringModeMgr/cardReader/1/ReaderEngineeringModeParams?format=json";
$response = sendGetRequest($host, $endpoint);
array_push($responseList, $response);

$endpoint = "ISAPI/AccessControl/CardReaderCfg/1?format=json";
$response = sendGetRequest($host, $endpoint);
array_push($responseList, $response);

$endpoint = "ISAPI/AccessControl/maskDetection?format=json";
$response = sendGetRequest($host, $endpoint);
array_push($responseList, $response);

$endpoint = "ISAPI/AccessControl/IdentityTerminal";
$response = sendGetRequest($host, $endpoint);
array_push($responseList, $response);

$endpoint = "ISAPI/AccessControl/FaceCompareCond";
$response = sendGetRequest($host, $endpoint);
array_push($responseList, $response);


echo json_encode($responseList);