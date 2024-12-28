<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateKeyConfiguration($host, $xmlBody)
{
  $url = "https://$host/ISAPI/VideoIntercom/keyCfg/1";
  return isAPI($url, 'PUT', $xmlBody);
}

$callMethod = reqBody()['callMethod'];

$xmlBody = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
  . "<KeyCfg version=\"2.0\" xmlns=\"http://www.isapi.org/ver20/XMLSchema\">"
  . "<id>1</id>"
  . "<enableCallCenter>false</enableCallCenter>"
  . "<callMethod>$callMethod</callMethod>"
  . "</KeyCfg>";

echo json_encode(updateKeyConfiguration($host, $xmlBody));

// header("Location: press-button.php");
