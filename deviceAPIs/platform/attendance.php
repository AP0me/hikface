<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchAttendanceMode($host)
{
  $url = "https://$host/ISAPI/AccessControl/Configuration/attendanceMode?format=json";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET

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

  // Decode JSON response
  return json_decode($response);
}

// Fetch attendance mode configuration
$attendanceData = fetchAttendanceMode($host)->AttendanceMode;
// print_r(json_encode($attendanceData));


function fetchKeyAttendance($host, $attendTypeID)
{
  $url = "https://$host/ISAPI/AccessControl/keyCfg/$attendTypeID/attendance?format=json";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET

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

  // Decode JSON response
  return json_decode($response, true);
}

// Fetch attendance configuration for the key
$attendTypeIDMap = [
  1 => 'checkIn',
  2 => 'checkOut',
  3 => 'breakOut',
  4 => 'breakIn',
  5 => 'overTimeIn',
  6 => 'overTimeOut',
];

$attendanceTypes = [];
foreach ($attendTypeIDMap as $key => $value) {
  $attendTypeID = $key;
  $attendanceTypes[$value] = fetchKeyAttendance($host, $attendTypeID);
  // print_r(json_encode($attendanceTypes[$value]).'<br>');
}
echo '<br>';

function fetchAttendanceWeekPlan($host, $planTypeID)
{
  $url = "https://$host/ISAPI/AccessControl/Attendance/weekPlan/$planTypeID?format=json";
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

  $ch = deviceAuth($ch);
  
  $response = curl_exec($ch);
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    return null;
  }
  curl_close($ch);
  return json_decode($response, true)['AttendanceWeekPlan'];
}

$attendTypeWeekIDMap = [
  1 => 'checkIn',
  2 => 'breakOut',
  3 => 'overTimeIn',
];
$weekPlanData = [
  "checkIn" => [],
  "breakOut" => [],
  "overTimeIn" => [],
];
foreach ($attendTypeWeekIDMap as $key => $value) {
  $planTypeID = $key;
  // print_r($value.'<br>');
  $weekPlan = fetchAttendanceWeekPlan($host, $planTypeID);
  foreach ($weekPlan['WeekPlanCfg'] as $key => $value2) {
    // print_r('--'.json_encode($key).': '.json_encode($value2).'<br>');
    $weekPlanData[$value][] = $value2;
  }
}


$attendenceReturn = [
  "attendanceData" => $attendanceData,
  "attendanceTypes" => $attendanceTypes,
  "weekPlanData" => $weekPlanData,
];

echo json_encode($attendenceReturn);
