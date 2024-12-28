<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateCustomPrompt($host)
{
  $url = "https://$host/ISAPI/AccessControl/customPrompt?format=json";
  $reqBody = reqBody();
  $jsonBody = json_encode([
    "enabled" => true,
    "PromptList" => [
      [
        "promptType" => "stranger",
        "promptContent" => $reqBody['stranger']
      ],
      [
        "promptType" => "authenticationSuccess",
        "promptContent" => $reqBody['authenticated']
      ],
      [
        "promptType" => "authenticationFailed",
        "promptContent" => $reqBody['authenticating_failed']
      ]
    ]
  ]);
  $response = isAPI($url, 'PUT', $jsonBody);
  if(isset($response->error)){
    return $response->error;
  }
  return $response;
}


$response = updateCustomPrompt($host);
echo $response;
