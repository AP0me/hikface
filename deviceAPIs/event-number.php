<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchAcsEventTotalNum($host)
{
  $url = "https://$host/ISAPI/AccessControl/AcsEventTotalNum?format=json";
  $data = json_encode([
    "AcsEventTotalNumCond" => [
      "major" => 0,
      "minor" => 0
    ]
  ]);
  $response = isAPI($url, "POST", $data)->AcsEventTotalNum->totalNum;
  return $response;
}

// Example usage

