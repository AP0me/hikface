<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function updateProgram($host, $xmlBody)
{
    $url = "https://$host/ISAPI/Publish/ProgramMgr/program/1";
    $response = isAPI($url, 'PUT', $xmlBody);
    if (isset($response->error)) {
        return $response->error;
    }
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

echo json_encode(updateProgram($host, $xmlBody));
