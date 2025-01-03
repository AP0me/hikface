<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateM1CardEncryptCfg($host, $xmlBody)
{
  $url = "https://$host/ISAPI/AccessControl/M1CardEncryptCfg";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody);

  $ch = deviceAuth($ch);

  // Execute cURL request
  $response = curl_exec($ch);

  // Handle errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    echo json_encode(xmlToJson($response));
  }

  curl_close($ch);
}
$xmlBody = '<?xml version="1.0" encoding="UTF-8"?>'
  . '<M1CardEncryptCfg version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">'
  . '<enable>false</enable>'
  . '<sectionID>13</sectionID>'
  . '</M1CardEncryptCfg>';
updateM1CardEncryptCfg($host, $xmlBody);


function updateNFCCfg($host, $jsonBody)
{
  $url = "https://$host/ISAPI/AccessControl/Configuration/NFCCfg?format=json";

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

  $ch = deviceAuth($ch);

  $response = curl_exec($ch);

  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    echo $response;
  }

  curl_close($ch);
}
$jsonBody = json_encode(["NFCCfg" => ["enable" => true]]);
updateNFCCfg($host, $jsonBody);


function updateRFCardCfg($host, $jsonBody)
{
  $url = "https://$host/ISAPI/AccessControl/Configuration/RFCardCfg?format=json";

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

  $ch = deviceAuth($ch);

  $response = curl_exec($ch);

  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    echo $response;
  }

  curl_close($ch);
}

$reqBody = reqBody();
if (isset($reqBody['RFCardCfg'])) {
  $jsonBody = json_encode([
    "RFCardCfg" => json_decode($reqBody['RFCardCfg']),
  ]);
} else {
  $jsonBody = json_encode([
    "RFCardCfg" => [
      ["cardType" => "EMCard", "enabled" => true],
      ["cardType" => "M1Card", "enabled" => true],
      ["cardType" => "CPUCard", "enabled" => true],
      ["cardType" => "DesfireCard", "enabled" => true],
      ["cardType" => "FelicaCard", "enabled" => true],
    ]
  ]);
}

updateRFCardCfg($host, $jsonBody);
