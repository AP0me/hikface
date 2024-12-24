<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchNetwork($host)
{
    $url = "https://$host/ISAPI/Event/notification/httpHosts?security=1&iv=ea89e569f0513a02629d6a0419baa843";

    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET

    $ch = deviceAuth($ch);


    // Execute cURL request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    } else {
        echo "Response: " . $response . '<br><br>';
        $xml = new SimpleXMLElement($response);
        print_r((string)$xml->HttpHostNotification->ipAddress);
        echo '<br><br>';
        print_r((string)$xml->HttpHostNotification->url);
        echo '<br><br>';
        print_r((string)$xml->HttpHostNotification->portNo);
        echo '<br><br>';
        print_r((string)$xml->HttpHostNotification->protocolType);
        echo '<br><br>';
        print_r($xml);
    }

    // Close cURL session
    curl_close($ch);
}
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
        echo "Response: " . $response;
        $xml = new SimpleXMLElement($response);
        print_r($xml);
        echo "Version: " . $xml['version'] . "<br>";
        for ($i = 0; $i < count($xml->AdminAccessProtocol); $i++) {
            echo $xml->AdminAccessProtocol[$i]->id . ' ';
            echo (isset($xml->AdminAccessProtocol[$i]->enabled) ? $xml->AdminAccessProtocol[$i]->enabled : 'false') . ' ';
            echo $xml->AdminAccessProtocol[$i]->protocol . ' ';
            echo $xml->AdminAccessProtocol[$i]->portNo . '<br> ';
        }
        curl_close($ch);
    }
}
http($host);
fetchNetwork($host);
