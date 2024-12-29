<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updatePlaySchedule($host, $schedule_start, $schedule_end)
{
  $url = "https://$host/ISAPI/Publish/ScheduleMgr/playSchedule/1";

  // XML body for the request
  $xmlBody = <<<XML
  <?xml version="1.0" encoding="UTF-8"?>
  <PlaySchedule version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
      <id>1</id>
      <scheduleName>web</scheduleName>
      <scheduleMode>screensaver</scheduleMode>
      <scheduleType>daily</scheduleType>
      <DailySchedule>
          <PlaySpanList>
              <PlaySpan>
                  <id>1</id>
                  <programNo>1</programNo>
                  <TimeRange>
                      <beginTime>$schedule_start</beginTime>
                      <endTime>$schedule_end</endTime>
                  </TimeRange>
              </PlaySpan>
          </PlaySpanList>
      </DailySchedule>
  </PlaySchedule>
  XML;

  $response = isAPI($url, 'PUT', $xmlBody);
  if (isset($response->error)) {
    return $response->error;
  }
  return $response;
}

function deletePlaySchedule($host)
{
  $url = "https://$host/ISAPI/Publish/ScheduleMgr/playSchedule/1";
  $response = isAPI($url, 'DELETE');
  if (isset($response->error)) {
    return $response->error;
  }
  return $response;
}

$reqBody = reqBody();
$schedule_start = $reqBody['schedule_start']; // 02:00:00
$schedule_end = $reqBody['schedule_end']; // 17:30:00

if (isset($schedule_start) && isset($schedule_end) && $schedule_start != '' && $schedule_end != '') {
  echo json_encode([
    "deletePlaySchedule" => updatePlaySchedule($host, $schedule_start, $schedule_end),
    "updatePlaySchedule" => updatePlaySchedule($host, $schedule_start, $schedule_end),
  ]);
} else {
  echo json_encode(["error" => "Please provide both schedule_start and schedule_end parameters."]);
}
