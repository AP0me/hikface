<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateIdentityTerminal($host, $screenDisplayPreference)
{
  $url = "https://$host/ISAPI/AccessControl/IdentityTerminal";
  $enableScreenOff = ($screenDisplayPreference['sleep'])?'true':'false';
  $screenOffTimeout = $screenDisplayPreference['sleepAfter'];
  $showMode = $screenDisplayPreference['themeMode'];

  // XML payload
  $xmlBody = <<<XML
  <?xml version="1.0" encoding="UTF-8"?>
  <IdentityTerminal version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
    <faceAlgorithm>DeepLearn</faceAlgorithm>
    <comNo/>
    <memoryLearning/>
    <saveCertifiedImage>enable</saveCertifiedImage>
    <readInfoOfCard>serialNo</readInfoOfCard>
    <workMode>accessControlMode</workMode>
    <ecoMode>
      <eco>enable</eco>
      <faceMatchThreshold1>60</faceMatchThreshold1>
      <faceMatchThresholdN>80</faceMatchThresholdN>
      <changeThreshold>4</changeThreshold>
      <maskFaceMatchThresholdN>70</maskFaceMatchThresholdN>
      <maskFaceMatchThreshold1>70</maskFaceMatchThreshold1>
    </ecoMode>
    <enableScreenOff>$enableScreenOff</enableScreenOff>
    <screenOffTimeout>$screenOffTimeout</screenOffTimeout>
    <showMode>$showMode</showMode>
  </IdentityTerminal>
  XML;
  // var_dump(xmlToJson($xmlBody));
  // exit;

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody); // Attach XML payload

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

  // Return the response
  return xmlToJson($response);
}

// Example usage
$screenDisplayPreference = reqBody()['screenDisplayPreference'];
// print_r($screenDisplayPreference);
// die;
$response = updateIdentityTerminal($host, (array)$screenDisplayPreference);

if ($response) {
  echo json_encode($response);
} else {
  echo "Failed to update Identity Terminal.";
}
