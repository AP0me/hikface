<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateAttendanceMode($host, $attendanceMode, $attendanceStatusTime, $reqAttendanceStatus)
{
  $url = "https://$host/ISAPI/AccessControl/Configuration/attendanceMode?format=json";

  $jsonBody = json_encode([
    "AttendanceMode" => [
      "mode" => $attendanceMode,
      "attendanceStatusTime" => $attendanceStatusTime,
      "reqAttendanceStatus" => $reqAttendanceStatus
    ]
  ]);

  $response = isAPI($url, 'PUT', $jsonBody);
  if (isset($response->error)) {
    echo $response->error;
    return null;
  }
  // Decode and return the response
  return (array)$response;
}

$attendanceSaveStatusData = [];

// Example usage
// print_r(reqBody()['attendanceData']);
$attendanceData = reqBody()['attendanceData'];
$attendanceMode = $attendanceData['mode'];
$attendanceStatusTime = $attendanceData['attendanceStatusTime'];
$reqAttendanceStatus = $attendanceData['reqAttendanceStatus'];
$attendanceModeUpdate = updateAttendanceMode($host, $attendanceMode, $attendanceStatusTime, $reqAttendanceStatus);
$attendanceSaveStatusData[] = $attendanceModeUpdate;

function updateKeyAttendance($host, $attendTypeID, $attendTypeName, $attendTypeLabel)
{
  $url = "https://$host/ISAPI/AccessControl/keyCfg/$attendTypeID/attendance?format=json";
  $jsonBody = json_encode([
    "Attendance" => [
      "enable" => false,
      "attendanceStatus" => "$attendTypeName",
      "label" => "$attendTypeLabel"
    ]
  ]);
  $response = isAPI($url, 'PUT', $jsonBody);
  if (isset($response->error)) {
    echo $response->error;
    return null;
  }
  return (array)$response;
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
  $attendTypeID = $key;
  $attendTypeName = $value[0];
  $attendTypeLabel = $value[1];
  $keyAttendanceUpdate = updateKeyAttendance($host, $attendTypeID, $attendTypeName, $attendTypeLabel);
  $attendanceSaveStatusData[] = $keyAttendanceUpdate;
}



function updateAttendancePlanTemplate($host)
{
  $url = "https://$host/ISAPI/AccessControl/Attendance/planTemplate/1?format=json";
  // TODO: This is a placeholder request body.
  $jsonBody = json_encode([
    "AttendancePlanTemplate" => [
      "enable" => true,
      "property" => "check",
      "templateName" => "template1",
      "weekPlanNo" => 1
    ]
  ]);
  $response = isAPI($url, 'PUT', $jsonBody);
  if (isset($response->error)) {
    echo $response->error;
    return null;
  }

  // Decode and return the response
  return (array)$response;
}

// Example usage
$planTemplateUpdate = updateAttendancePlanTemplate($host);
$attendanceSaveStatusData[] = $planTemplateUpdate;

function updateAttendanceWeekPlan($host)
{
  $url = "https://$host/ISAPI/AccessControl/Attendance/weekPlan/1?format=json";
  // TODO: This is a placeholder request body.
  $jsonBody = json_encode([
    "AttendanceWeekPlan" => [
      "enable" => true,
      "WeekPlanCfg" => []
    ]
  ]);
  $response = isAPI($url, 'PUT', $jsonBody);
  if (isset($response->error)) {
    echo $response->error;
    return null;
  }
  return (array)$response;
}

$weekPlanUpdate = updateAttendanceWeekPlan($host);
$attendanceSaveStatusData[] = $weekPlanUpdate;

echo json_encode($attendanceSaveStatusData);
