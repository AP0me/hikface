<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function updateProgram($host, $xmlBody)
{
  $url = "https://$host/ISAPI/Publish/ProgramMgr/program/1";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody); // Attach XML body

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

// Example usage
$programName = reqBody()['program_name'];

$xmlBody = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Program xmlns="http://www.isapi.org/ver20/XMLSchema">
    <id>1</id>
    <programName>$programName</programName>
    <programRemarks/>
    <programType>screensaver</programType>
    <Resolution>
        <imageWidth>600</imageWidth>
        <imageHeight>704</imageHeight>
    </Resolution>
    <PageList>
        <Page>
            <id>1</id>
            <PageBasicInfo>
                <pageName/>
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
                </Windows>
            </WindowsList>
        </Page>
    </PageList>
    <coordinateType>uniformCoordinate</coordinateType>
    <PageIdList>
        <PageId>
            <id>1</id>
        </PageId>
    </PageIdList>
</Program>
XML;

$response = updateProgram($host, $xmlBody);
echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
