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
function fetchAcsEvent($logsTableValueMap, $host)
{
  $url = "https://$host/ISAPI/AccessControl/AcsEvent?format=json&security=1&iv=90b54a4c844c94bfe780ecf7b535a00e";

  // Request body
  $data = json_encode([
    "AcsEventCond" => [
      "searchID" => "57f48f21928740cb86119fbb878c2c8f",
      "searchResultPosition" => 0,
      "maxResults" => 20,
      "major" => 0,
      "minor" => 0,
      // "startTime" => "2024-12-06T00:00:00+08:00",
      // "endTime" => "2024-12-06T23:59:59+08:00",
      "timeReverseOrder" => true
    ]
  ]);

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for local testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

  $ch = deviceAuth($ch);

  // Execute cURL request
  $response = json_decode(curl_exec($ch));

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
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
  }

  // Close cURL session
  curl_close($ch);
  return $processedLogs;
}
