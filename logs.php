<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

class LogRow
{
  public $employeeID;
  public $name;
  public $cardNum;
  public $eventType;
  public $time;
  public $operation;
  public function __construct($employeeID, $name, $cardNum, $eventType, $time, $operation,)
  {
  $this->employeeID = $employeeID;
  $this->name = $name;
  $this->cardNum = $cardNum;
  $this->eventType = $eventType;
  $this->time = $time;
  $this->operation = $operation;
  }
}
function fetchAcsEvent($logsTableValueMap, $host, $data)
{
  $url = "https://$host/ISAPI/AccessControl/AcsEvent?format=json&security=1&iv=90b54a4c844c94bfe780ecf7b535a00e";
  $response = isAPI($url, "POST", $data);

  $processedLogs = [];
  $infos = (array)($response->AcsEvent->InfoList);
  foreach ($infos as $info) {
    $processedLogs[] = new LogRow(
      $info->employeeNoString ?? '-',
      $info->name ?? '-',
      $info->cardNo ?? '-',
      $logsTableValueMap->majors->{$info->major}->minors->{$info->minor} ?? '-',
      $info->time ?? '-',
      (isset($info->pictureURL) ? $info->pictureURL . "?1734011388935=&token=" : "-"),
    );
  }
  
  return $processedLogs;
}
