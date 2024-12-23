<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function isupOne($host)
{
    $url = "https://$host/ISAPI/System/Network/Ehome?centerID=1&security=1&iv=a12ef7c7f6a658c60a965d4a060cba4d";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET
    $username = "admin";
    $password = "12345678m";
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
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
