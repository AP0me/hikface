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
  $response = isAPI($url, 'PUT', $xmlBody);
  if (isset($response->error)) {
    return $response->error;
  }
  return $response;
}

// Example usage
$screenDisplayPreference = reqBody()['screenDisplayPreference'];
// print_r($screenDisplayPreference);
// die;
$response = updateIdentityTerminal($host, (array)$screenDisplayPreference);
echo json_encode($response);