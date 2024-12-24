<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function http($host) {
$url = "https://$host/ISAPI/Security/adminAccesses";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET
    $username = "admin";
    $password = "12345678m";
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    } else {
       
        $xml = new SimpleXMLElement($response);
        print_r($xml);
        echo "Version: " . $xml['version'] . "<br>";
            echo $xml->AdminAccessProtocol[1]->portNo .'<br> ';
        
    curl_close($ch);
}}
http($host);
