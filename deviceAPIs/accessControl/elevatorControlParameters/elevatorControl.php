<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function elevatorControlParameter($host)
{
    $url = "https://$host/ISAPI/VideoIntercom/Elevators/1/ControlCfg?format=json&security=1&iv=6b5633d7e91a7bff94e5465fd6be8f5d";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET

    $ch = deviceAuth($ch);


    $response = json_decode(curl_exec($ch));
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    } else {
        print_r($response);
        echo '<br>';
        print_r($response->ElevatorControlCfg->enable);
        echo '<br>';
        print_r($response->ElevatorControlCfg->deviceType);
        echo '<br>';
        if ($response->ElevatorControlCfg->interfaceType = 1) {
            echo 'RS-485';
        } else {
            echo 'Network İnterface';
        }

        print_r($response->ElevatorControlCfg->interfaceType);
        echo '<br>';

        print_r($response->ElevatorControlCfg->numOfNegFloors);
        echo '<br>';
        print_r($response->ElevatorControlCfg->ServerAddress->ipAddress);
        echo '<br>';
        print_r($response->ElevatorControlCfg->serverPort);
        echo '<br>';
    }
    curl_close($ch);
}
elevatorControlParameter($host);
