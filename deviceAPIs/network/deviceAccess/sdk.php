<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function http($host)
{
    $url = "https://$host/ISAPI/Security/adminAccesses";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET

    $ch = deviceAuth($ch);


    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    } else {

        $xml = new SimpleXMLElement($response);
        print_r($xml);
        echo "Version: " . $xml['version'] . "<br>";
        echo $xml->AdminAccessProtocol[1]->portNo . '<br> ';

        curl_close($ch);
    }
}
http($host);
