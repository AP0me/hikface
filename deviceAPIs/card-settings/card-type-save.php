<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateM1CardEncryptCfg($host, $xmlBody)
{
  $url = "https://$host/ISAPI/AccessControl/M1CardEncryptCfg";
  return isAPI($url, "PUT", $xmlBody);
}

$xmlBody = <<<XML
  <?xml version="1.0" encoding="UTF-8"?>
  <M1CardEncryptCfg version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
    <enable>false</enable>
    <sectionID>13</sectionID>
  </M1CardEncryptCfg>
  XML;
echo json_encode(updateM1CardEncryptCfg($host, $xmlBody));


function updateNFCCfg($host, $jsonBody)
{
  $url = "https://$host/ISAPI/AccessControl/Configuration/NFCCfg?format=json";
  isAPI($url, "PUT", $jsonBody);
}
$jsonBody = json_encode(["NFCCfg" => ["enable" => true]]);
updateNFCCfg($host, $jsonBody);


function updateRFCardCfg($host, $jsonBody): array
{
  $url = "https://$host/ISAPI/AccessControl/Configuration/RFCardCfg?format=json";
  return isAPI($url, "PUT", $jsonBody);
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

echo json_encode(updateRFCardCfg($host, $jsonBody));
