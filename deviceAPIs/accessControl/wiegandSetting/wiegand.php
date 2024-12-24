<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function fetchNetworkInterfaces($host) {
    $url = "https://$host/ISAPI/AccessControl/WiegandCfg/wiegandNo/1";
    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET

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
    } else {
       $xml=new SimpleXMLElement($response);
       print_r($xml);echo '<br>';
       print_r(((string)$xml->enable=='true') ? 'true' : 0);echo '<br>';
       print_r( ((string)$xml->enable=='true') ? (string)$xml->communicateDirection : 0);echo '<br>';
       print_r(((string)$xml->enable=='true') ? (string)$xml->wiegandMode : 0);
    }
    curl_close($ch);
}
fetchNetworkInterfaces($host);