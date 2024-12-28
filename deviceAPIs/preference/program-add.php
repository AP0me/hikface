<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function createProgram($host, $programName)
{
    $url = "https://$host/ISAPI/Publish/ProgramMgr/program";

    // XML body for the request
    $xmlBody = <<<XML
    <?xml version="1.0" encoding="UTF-8"?>
    <Program version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
        <id>1</id>
        <programName>$programName</programName>
        <programRemarks/>
        <programType>screensaver</programType>
        <Resolution>
            <resolutionName>600*704</resolutionName>
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
    </Program>
    XML;

    $response = isAPI($url, 'POST', $xmlBody);
    if (isset($response->error)) {
        return $response->error;
    }
    return $response;
}

$programName = reqBody()['program_name'];
$response = json_encode(createProgram($host, $programName));
echo $response;
