<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function home($host)
{
  $url = "https://$host/ISAPI/AccessControl/CardReaderCfg/1?format=json";
  $response = isAPI($url, "GET");

  // Check for errors
  if (isset($response->error)) {
    echo "cURL Error: " . $response->error;
  } else {
    return [
      "cardReaderFunction" => $response->CardReaderCfg->cardReaderFunction,
      "cardReaderDescription" => $response->CardReaderCfg->cardReaderDescription,
      "enable" => $response->CardReaderCfg->enable,
      "defaultVerifyMode" => $response->CardReaderCfg->defaultVerifyMode,
      "faceRecogizeInterval" => $response->CardReaderCfg->faceRecogizeInterval,
      "independSwipeIntervals" => $response->CardReaderCfg->independSwipeIntervals,
      "enableFailAlarm" => $response->CardReaderCfg->enableFailAlarm,
      "maxReadCardFailNum" => $response->CardReaderCfg->maxReadCardFailNum,
      "enableTamperCheck" => $response->CardReaderCfg->enableTamperCheck,
      "enableReverseCardNo" => $response->CardReaderCfg->enableReverseCardNo,
    ];
  }
}

function assistant($host)
{
  $url = "https://$host/ISAPI/AccessControl/CardReaderCfg/2?format=json";
  $response = isAPI($url, "GET");

  // Check for errors
  if (isset($response->error)) {
    echo "cURL Error: " . $response->error;
  } else {
    $cardReaderFunctionProcessed = [];
    for ($i = 0; $i < count($response->CardReaderCfg->cardReaderFunction); $i++) {
      array_push($cardReaderFunctionProcessed, $response->CardReaderCfg->cardReaderFunction[$i]);
    }
    return [
      'cardReaderFunctionProcessed' => $cardReaderFunctionProcessed,
      "cardReaderDescription" => $response->CardReaderCfg->cardReaderDescription,
      "enable" => $response->CardReaderCfg->enable,
      "defaultVerifyMode" => $response->CardReaderCfg->defaultVerifyMode,
      "faceRecogizeInterval" => $response->CardReaderCfg->faceRecogizeInterval,
      "enableFailAlarm" => $response->CardReaderCfg->enableFailAlarm,
      "maxReadCardFailNum" => $response->CardReaderCfg->maxReadCardFailNum,
      "offlineCheckTime" => $response->CardReaderCfg->offlineCheckTime,
      "pressTimeout" => $response->CardReaderCfg->pressTimeout,
      "okLedPolarity" => $response->CardReaderCfg->okLedPolarity,
      "errorLedPolarity" => $response->CardReaderCfg->errorLedPolarity,
      "enableTamperCheck" => $response->CardReaderCfg->enableTamperCheck,
    ];
  }
}

$data = json_encode([
  "CardReaderCfg" => reqBody()["CardReaderCfg"],
]);
echo json_encode([
  "home" => home($host),
  "assistant" => assistant($host),
]);
