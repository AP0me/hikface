<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function doorParameters($host)
{
    $url = "https://$host/ISAPI/AccessControl/Door/param/1?security=1&iv=70afca2183976d5a28453cd5edc7f01a";

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

    // Set headers
    $headers = [
        "Accept: */*",
        "Accept-Language: tr,en;q=0.9,en-GB;q=0.8,en-US;q=0.7",
        "Cache-Control: max-age=0",
        "If-Modified-Since: 0",
        "Sec-CH-UA: \"Microsoft Edge\";v=\"131\", \"Chromium\";v=\"131\", \"Not_A Brand\";v=\"24\"",
        "Sec-CH-UA-Mobile: ?0",
        "Sec-CH-UA-Platform: \"Windows\"",
        "Sec-Fetch-Dest: empty",
        "Sec-Fetch-Mode: cors",
        "Sec-Fetch-Site: same-origin",
        "SessionTag: 903GVRAU5478XFTMX8RA5U8AK3DOKQ5PX10JPLBK1WYZJYEDSBZ8NHEJB56PPUMP",
        "X-Requested-With: XMLHttpRequest"
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    } else {
        $xml = new SimpleXMLElement($response);
        print_r($xml);
        echo '<br>';
        print_r((string)$xml->doorName);
        echo '<br>';
        print_r((string)$xml->openDuration);
        echo '<br>';
        print_r((string)$xml->magneticAlarmTimeout);
        echo '<br>';
        print_r((string)$xml->magneticType);
        echo '<br>';
        print_r((string)$xml->openButtonType);
        echo '<br>';
        print_r((string)$xml->disabledOpenDuration);
        echo '<br>';
        print_r((string)$xml->leaderCardOpenDuration);
        echo '<br>';
        echo 'Zorlama Kodu:<br>';
        echo 'Super Parol:<br>';
    }

    // Close cURL session
    curl_close($ch);
}
doorParameters($host);
function lockTypeStatus($host)
{
    $url = "https://$host/ISAPI/AccessControl/Configuration/lockType?format=json";

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

    // Set headers
    $headers = [
        "Accept: */*",
        "Accept-Language: tr,en;q=0.9,en-GB;q=0.8,en-US;q=0.7",
        "Cache-Control: max-age=0",
        "If-Modified-Since: 0",
        "Sec-CH-UA: \"Microsoft Edge\";v=\"131\", \"Chromium\";v=\"131\", \"Not_A Brand\";v=\"24\"",
        "Sec-CH-UA-Mobile: ?0",
        "Sec-CH-UA-Platform: \"Windows\"",
        "Sec-Fetch-Dest: empty",
        "Sec-Fetch-Mode: cors",
        "Sec-Fetch-Site: same-origin",
        "SessionTag: 903GVRAU5478XFTMX8RA5U8AK3DOKQ5PX10JPLBK1WYZJYEDSBZ8NHEJB56PPUMP",
        "X-Requested-With: XMLHttpRequest"
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Execute cURL request
    $response = json_decode(curl_exec($ch));

    // Check for errors
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    } else {
        print_r($response->LockType->status);
    }

    // Close cURL session
    curl_close($ch);
}
lockTypeStatus($host);
