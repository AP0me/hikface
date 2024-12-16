<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function updatePlaySchedule($host)
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
                    <beginTime>02:00:00</beginTime>
                    <endTime>17:30:00</endTime>
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

  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

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
  return $response;
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

  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

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
  return $response;
}


$schedule_start = $_GET['schedule_start'];
$schedule_end = $_GET['schedule_end'];

if (isset($schedule_start) && isset($schedule_end) && $schedule_start != '' && $schedule_end != '') {
  $response = deletePlaySchedule($host);
  echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";

  $response = updatePlaySchedule($host);
  echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
} else {
  echo "Please provide both schedule_start and schedule_end parameters.";
}
