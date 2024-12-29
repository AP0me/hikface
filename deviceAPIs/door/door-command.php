<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function doorCommand($host, $command)
{
  $url = "https://$host/ISAPI/AccessControl/RemoteControl/door/1";
  $data = <<<XML
    <RemoteControlDoor version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
      <cmd>$command</cmd>
    </RemoteControlDoor>
  XML;
  $response = isAPI($url, "PUT", $data);
  if (isset($response->error)) {
    echo $response->error;
  }
  echo json_encode($response);
}
