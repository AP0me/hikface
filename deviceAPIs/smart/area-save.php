<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';


function updateFaceCompareCond($host, $borderData)
{
  $url = "https://$host/ISAPI/AccessControl/FaceCompareCond";
  $leftBorder = $borderData['leftBorder'];
  $rightBorder = $borderData['rightBorder'];
  $upBorder = $borderData['upBorder'];
  $bottomBorder = $borderData['bottomBorder'];

  // XML body
  $xmlBody = <<<XML
  <FaceCompareCond version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
      <pitch>45</pitch>
      <yaw>45</yaw>
      <leftBorder>$leftBorder</leftBorder>
      <rightBorder>$rightBorder</rightBorder>
      <upBorder>$upBorder</upBorder>
      <bottomBorder>$bottomBorder</bottomBorder>
      <faceScore>0</faceScore>
      <maxDistance>auto</maxDistance>
  </FaceCompareCond>
  XML;

  $response = isAPI($url, 'PUT', $xmlBody);
  if (isset($response->error)) {
    return $response->error;
  }
  return $response;
}

$borderData = reqBody()['borderData'];
$response = updateFaceCompareCond($host, (array)$borderData);
echo json_encode($response);
