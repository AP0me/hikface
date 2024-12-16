<?php
function fetchNetworkInterfaces($host) {
    $url = 'https://192.168.0.116/ISAPI/AccessControl/EngineeringModeMgr/cardReader/1/ReaderEngineeringModeParams?format=json';
    $ch = curl_init($url);
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
        print_r(json_decode($response));echo '<br><br>';
        print_r(json_decode($response)->antiSpoofingDetParams);echo '<br>';
        print_r((json_decode($response)->antiSpoofingDetParams->customEnabled) ? 'true' : 'false'); echo '<br>';
      
        print_r(json_decode($response)->antiSpoofingDetParams->antiSpoofingDetLevel); echo '<br>';  
        print_r(json_decode($response)->antiSpoofingDetParams->antiSpoofingDetThreshold); echo '<br>';
        print_r(json_decode($response)->antiSpoofingDetParams->maskAntiSpoofingDetThreshold); echo '<br>';
        print_r((json_decode($response)->antiSpoofingDetParams->antiAttackEnabled) ? 'true' : 'false');  echo '<br>';
        print_r(json_decode($response)->antiSpoofingDetParams->antiAttackLockTime); echo '<br><br>';

        print_r(json_decode($response)->readerVersion->BSPVersion); echo '<br>';
        print_r(json_decode($response)->readerVersion->DSPVersion); echo '<br>'; 
        print_r(json_decode($response)->readerVersion->engineVersion); echo '<br>';
        print_r(json_decode($response)->readerVersion->faceAlgorithmVersion); echo '<br>';
        print_r(json_decode($response)->readerVersion->antiSpoofingAlgorithmVersion); echo '<br>';
    }
    curl_close($ch);
}
fetchNetworkInterfaces("192.168.0.116");