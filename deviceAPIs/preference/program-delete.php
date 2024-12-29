<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';


function deleteProgram($host)
{
  $url = "https://$host/ISAPI/Publish/ProgramMgr/program/1";
  $response = isAPI($url, 'DELETE');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  return $response;
}


echo json_encode(deleteProgram($host));
