<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function doorCommand($host, $command, $redirectURL){
  $url = "https://$host/ISAPI/AccessControl/RemoteControl/door/1";
  $data = '<RemoteControlDoor version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema"><cmd>'.$command.'</cmd></RemoteControlDoor>';

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for local testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

  $ch = deviceAuth($ch);

  // Set additional headers
  $headers = [
  "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
  echo "cURL Error: " . curl_error($ch);
  } else {
    echo json_encode(xmlToJson($response));
  }

  // Close cURL session
  curl_close($ch);
  // header("location: $redirectURL");
  // exit;
}
