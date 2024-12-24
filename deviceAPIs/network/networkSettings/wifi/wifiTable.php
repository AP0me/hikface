<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchNetworkInterfaces($host) {
    $url = "https://$host/ISAPI/System/Network/interfaces/2/wireless/accessPointList";

    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET

    $ch = deviceAuth($ch);
    
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    } else {
        echo "Response: " . $response.'<br><br><br>';
        $xml = new SimpleXMLElement($response);
        print_r(count($xml));
        echo '<br><br><br><br>';
       
      
        
        // for ($i=0; $i <count($xml) ; $i++) { 
        //    print_r((string)$xml->accessPoint[$i]->id);
        //    echo '<br><br>';
        // }
    }
    curl_close($ch);
}

fetchNetworkInterfaces($host);