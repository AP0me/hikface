<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function imageSetting()
{
  $url = "https://192.168.0.116/ISAPI/Image/channels/1";
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET
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
    $xml = xmlToJson($response);
    return json_encode([
        'brightnessLevel' => $xml->Color->brightnessLevel,
        'contrastLevel' => $xml->Color->contrastLevel,
        'saturationLevel' => $xml->Color->saturationLevel,
        'SharpnessLevel' => $xml->Sharpness->SharpnessLevel,
        'mode' => $xml->WDR->mode,
        'powerLineFrequencyMode' => $xml->powerLineFrequency->powerLineFrequencyMode,
        'enabled' => $xml->Beauty->enabled,
        'whiteningStrength' => $xml->Beauty->whiteningStrength,
        'skinSmoothingStrength' => $xml->Beauty->skinSmoothingStrength,
      ]
    );
  }

  // Close cURL session
  curl_close($ch);
}
echo imageSetting();

function LED($a)
{
  $url = "https://192.168.0.116/ISAPI/Image/channels/$a/supplementLight";
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
  }

  // Close cURL session
  curl_close($ch);
}
LED('1');
LED('2');
