<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function updateAttendanceMode($host, $attendanceMode, $attendanceStatusTime, $reqAttendanceStatus)
{
  $url = "https://$host/ISAPI/AccessControl/Configuration/attendanceMode?format=json";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT

  // Set request body
  $jsonBody = json_encode([
    "AttendanceMode" => [
      "mode" => $attendanceMode,
      "attendanceStatusTime" => $attendanceStatusTime,
      "reqAttendanceStatus" => $reqAttendanceStatus
    ]
  ]);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Set headers
  $headers = [
    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8"
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    return null;
  }

  // Close cURL session
  curl_close($ch);

  // Decode and return the response
  return json_decode($response, true);
}

// Example usage
$attendanceMode = $_GET['attendanceData']->mode;
$attendanceStatusTime = $_GET['attendanceData']->attendanceStatusTime;
$reqAttendanceStatus = $_GET['attendanceData']->reqAttendanceStatus;
$attendanceModeUpdate = updateAttendanceMode($host, $attendanceMode, $attendanceStatusTime, $reqAttendanceStatus);

if ($attendanceModeUpdate) {
  echo '<pre>' . json_encode($attendanceModeUpdate, JSON_PRETTY_PRINT) . '</pre>';
} else {
  echo "Failed to update attendance mode configuration.";
}


function updateKeyAttendance($host, $attendTypeID, $attendTypeName, $attendTypeLabel)
{
  $url = "https://$host/ISAPI/AccessControl/keyCfg/$attendTypeID/attendance?format=json";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT

  // Set request body
  $jsonBody = json_encode([
    "Attendance" => [
      "enable" => false,
      "attendanceStatus" => "$attendTypeName",
      "label" => "$attendTypeLabel"
    ]
  ]);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Set headers
  $headers = [
    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8"
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    return null;
  }

  // Close cURL session
  curl_close($ch);

  // Decode and return the response
  return json_decode($response, true);
}

// Example usage
$attendTypeIDMap = [
  1 => ['checkIn', 'Check In'],
  2 => ['checkOut', 'Check Out'],
  3 => ['breakOut', 'Break Out'],
  4 => ['breakIn', 'Break In'],
  5 => ['overtimeIn', 'Overtime In'],
  6 => ['overtimeOut', 'Overtime Out'],
];

foreach ($attendTypeIDMap as $key => $value) {
  $attendTypeID = $key; $attendTypeName = $value[0]; $attendTypeLabel = $value[1];
  $keyAttendanceUpdate = updateKeyAttendance($host, $attendTypeID, $attendTypeName, $attendTypeLabel);
  if ($keyAttendanceUpdate) {
    echo '<pre>' . json_encode($keyAttendanceUpdate, JSON_PRETTY_PRINT) . '</pre>';
  } else {
    echo "Failed to update key attendance configuration.";
  }
}



function updateAttendancePlanTemplate($host)
{
  $url = "https://$host/ISAPI/AccessControl/Attendance/planTemplate/1?format=json";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT

  // Set request body
  $jsonBody = json_encode([
    "AttendancePlanTemplate" => [
      "enable" => true,
      "property" => "check",
      "templateName" => "template1",
      "weekPlanNo" => 1
    ]
  ]);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Set headers
  $headers = [
    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8"
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    return null;
  }

  // Close cURL session
  curl_close($ch);

  // Decode and return the response
  return json_decode($response, true);
}

// Example usage
$planTemplateUpdate = updateAttendancePlanTemplate($host);

if ($planTemplateUpdate) {
  echo '<pre>' . json_encode($planTemplateUpdate, JSON_PRETTY_PRINT) . '</pre>';
} else {
  echo "Failed to update attendance plan template.";
}


function updateAttendanceWeekPlan($host)
{
  $url = "https://$host/ISAPI/AccessControl/Attendance/weekPlan/1?format=json";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT

  // Set request body
  $jsonBody = json_encode([
    "AttendanceWeekPlan" => [
      "enable" => true,
      "WeekPlanCfg" => [] // Adjust configuration as needed
    ]
  ]);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Set headers
  $headers = [
    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8"
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    return null;
  }

  // Close cURL session
  curl_close($ch);

  // Decode and return the response
  return json_decode($response, true);
}

// Example usage
$weekPlanUpdate = updateAttendanceWeekPlan($host);

if ($weekPlanUpdate) {
  echo '<pre>' . json_encode($weekPlanUpdate, JSON_PRETTY_PRINT) . '</pre>';
} else {
  echo "Failed to update attendance week plan.";
}
