<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function enableSSH($host, $xmlBody)
{
  $url = "https://$host/ISAPI/System/Network/ssh";
  $reponse = isAPI($url, 'PUT', $xmlBody);
  if(isset($reponse->error)){
    return $reponse->error;
  }
  return $reponse;
}


// XML Body
$ssh_enabled = reqBody()['enabled'];
$xmlBody = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<SSH>
  <enabled>$ssh_enabled</enabled>
</SSH>
XML;
echo json_encode(enableSSH($host, $xmlBody));
