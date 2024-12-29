<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchAttendanceMode($host)
{
  $url = "https://$host/ISAPI/AccessControl/Configuration/attendanceMode?format=json";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  return $response;
}

$attendanceData = fetchAttendanceMode($host)->AttendanceMode;


function fetchKeyAttendance($host, $attendTypeID)
{
  $url = "https://$host/ISAPI/AccessControl/keyCfg/$attendTypeID/attendance?format=json";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  return $response;
}

function fetchAttendanceWeekPlan($host, $planTypeID)
{
  $url = "https://$host/ISAPI/AccessControl/Attendance/weekPlan/$planTypeID?format=json";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  return $response->AttendanceWeekPlan;
}

$attendTypeIDMap = [
  1 => 'checkIn',
  2 => 'checkOut',
  3 => 'breakOut',
  4 => 'breakIn',
  5 => 'overTimeIn',
  6 => 'overTimeOut',
];

$attendanceTypes = [];
foreach ($attendTypeIDMap as $attendTypeID => $value) {
  $attendanceTypes[$value] = fetchKeyAttendance($host, $attendTypeID);
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
