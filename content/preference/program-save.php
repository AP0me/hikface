<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function updateProgramPage($host, $xmlBody)
{
  $url = "https://$host/ISAPI/Publish/ProgramMgr/program/1/page/1";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody); // Attach XML body

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

$xmlBody = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Page version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
    <id>1</id>
    <PageBasicInfo>
        <pageName>1</pageName>
        <playDurationMode>1</playDurationMode>
        <switchDuration>1</switchDuration>
        <switchEffect>none</switchEffect>
    </PageBasicInfo>
    <WindowsList>
        <Windows>
            <id>1</id>
            <Position>
                <positionX>0</positionX>
                <positionY>0</positionY>
                <height>1920</height>
                <width>1920</width>
            </Position>
            <layerNo>1</layerNo>
            <WinMaterialInfo>
                <materialType>static</materialType>
                <staticMaterialType>picture</staticMaterialType>
            </WinMaterialInfo>
            <PlayItemList/>
        </Windows>
    </WindowsList>
</Page>
XML;

$response = updateProgramPage($host, $xmlBody);
echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";



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

$response = deletePlaySchedule($host);
echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";