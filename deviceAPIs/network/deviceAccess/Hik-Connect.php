<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchNetworkInterfaces($host) {
$url = "https://$host/ISAPI/System/Network/EZVIZ?security=1&iv=8ae15bdec0f9bbec7f0157bd53a29370";
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
        $xml=new SimpleXMLElement($response);
        print_r($xml); echo '<br>';
        print_r((string)$xml->enabled); echo '<br>';
        print_r((string)$xml->serverAddress->hostName); echo '<br>';
        print_r((string)$xml->verificationCode); echo '<br>'; 
        print_r((string)$xml->streamEncrypteEnabled); echo '<br>';
        for ($i=0; $i < count($xml->NetworkPriorityList->NetworkPriority); $i++) { 
           print_r((string)$xml->NetworkPriorityList->NetworkPriority[$i]->networkType); echo '<br>';
           print_r((string)$xml->NetworkPriorityList->NetworkPriority[$i]->priority); echo '<br>';
        }
       

    }
    curl_close($ch);
}
fetchNetworkInterfaces($host);