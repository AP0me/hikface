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

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody); // Attach XML body

  $ch = deviceAuth($ch);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    return null;
  }

  // Close cURL session
  curl_close($ch);

  // Return response
  return xmlToJson($response);
}

function deletePlaySchedule($host)
{
  $url = "https://$host/ISAPI/Publish/ScheduleMgr/playSchedule/1";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // Set method to DELETE

  $ch = deviceAuth($ch);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    return null;
  }

  // Close cURL session
  curl_close($ch);

  // Return response
  return xmlToJson($response);
}

$reqBody = reqBody();
$schedule_start = $reqBody['schedule_start']; // 02:00:00
$schedule_end = $reqBody['schedule_end']; // 17:30:00

if (isset($schedule_start) && isset($schedule_end) && $schedule_start != '' && $schedule_end != '') {
  $response = json_encode(deletePlaySchedule($host));
  echo $response;

  $response = json_encode(updatePlaySchedule($host, $schedule_start, $schedule_end));
  echo $response;
  
} else {
  echo "Please provide both schedule_start and schedule_end parameters.";
}
