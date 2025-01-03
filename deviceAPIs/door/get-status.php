<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchAcsWorkStatus($host)
{
  $url = "https://$host/ISAPI/AccessControl/AcsWorkStatus?format=json";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

  $ch = deviceAuth($ch);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  }
  else {
    $doorLockStatus = json_decode($response)->AcsWorkStatus;
    return $doorLockStatus->doorStatus[0];
  }

  // Close cURL session
  curl_close($ch);
}

$doorStatusNumberMap = [
  4 => 'controlled',
  2 => 'remainOpen',
  3 => 'remainClose',
];
$doorStatus = $doorStatusNumberMap[fetchAcsWorkStatus($host)];
echo json_encode(["doorStatus" => $doorStatus]);
