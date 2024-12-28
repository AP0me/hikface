<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function enableSSH($host, $xmlBody)
{
  $url = "https://$host/ISAPI/System/Network/ssh";
  return isAPI($url, 'PUT', $xmlBody);
}


// XML Body
$ssh_enabled = reqBody()['enabled'];
$xmlBody = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<SSH>
  <enabled>$ssh_enabled</enabled>
</SSH>
XML;
$response = enableSSH($host, $xmlBody);
echo json_encode($response);
