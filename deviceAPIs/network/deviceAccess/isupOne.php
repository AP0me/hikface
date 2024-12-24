<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function isupOne($host)
{
    $url = "https://$host/ISAPI/System/Network/Ehome?centerID=1&security=1&iv=a12ef7c7f6a658c60a965d4a060cba4d";
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
        print_r((string)$xml->enabled);
        echo '<br>';
        print_r((string)$xml->protocolVersion);
        echo '<br>';
        print_r((string)$xml->ipAddress);
        echo '<br>';
        print_r((string)$xml->portNo);
        echo '<br>';
        print_r((string)$xml->deviceID);
        echo '<br>';
        print_r((string)$xml->registerStatus);
    }
    curl_close($ch);
}
function isupTwo($host)
{
    // URL for the request
    $url = "https://$host/ISAPI/Event/notification/httpHosts?security=1&iv=fe2b15734bdebbaf1ee52324254b3655";

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


        $xml = new SimpleXMLElement($response);
        print_r($xml);
        echo '<br><br><br>';

        print_r((string)$xml->HttpHostNotification[1]->ipAddress);
        echo '<br>';
        print_r((string)$xml->HttpHostNotification[1]->url);
        echo '<br>';
        print_r((string)$xml->HttpHostNotification[1]->portNo);
        echo '<br>';
    }

    // Close cURL session
    curl_close($ch);
}
isupOne($host);
isupTwo($host);
