<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function home($host)
{
  $url = "https://$host/ISAPI/AccessControl/CardReaderCfg/1?format=json";

  // Digest authentication details
  $username = "admin";  // Replace with your Digest authentication username
  $password = "12345678m";  // Replace with your Digest authentication password

  // JSON data to be sent in the body of the request
  $data = json_encode([
    "CardReaderCfg" => [
      "enable" => true,
      "okLedPolarity" => "anode",
      "errorLedPolarity" => "anode",
      "swipeInterval" => 0,
      "enableFailAlarm" => true,
      "maxReadCardFailNum" => 5,
      "pressTimeout" => 10,
      "enableTamperCheck" => true,
      "offlineCheckTime" => 0,
      "fingerPrintCheckLevel" => 5,
      "faceMatchThresholdN" => 90,
      "faceRecogizeTimeOut" => 3,
      "faceRecogizeInterval" => 3,
      "cardReaderFunction" => ["fingerPrint", "face"],
      "cardReaderDescription" => "DS-K1T341CMFW",
      "livingBodyDetect" => true,
      "faceMatchThreshold1" => 60,
      "liveDetLevelSet" => "general",
      "liveDetAntiAttackCntLimit" => 100,
      "enableLiveDetAntiAttack" => true,
      "fingerPrintCapacity" => 3000,
      "fingerPrintNum" => 5,
      "defaultVerifyMode" => "faceOrFpOrCardOrPw",
      "faceRecogizeEnable" => 1,
      "enableReverseCardNo" => false,
      "independSwipeIntervals" => 0,
      "maskFaceMatchThresholdN" => 75,
      "maskFaceMatchThreshold1" => 75
    ]
  ]);

  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for local testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Set additional headers
  $headers = [
    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0",
    "Accept: */*",
    "Accept-Language: en-US,en;q=0.5",
    "If-Modified-Since: 0",
    "SessionTag: WIF1HDYXZHMY3SYCYFKDGN7N7QU5TSKFESKVK18OOCUSXVAJFTA9TIIXHELXZIND",
    "X-Requested-With: XMLHttpRequest",
    "Pragma: no-cache",
    "Cache-Control: no-cache"
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Execute cURL request
  $response = json_decode(curl_exec($ch));

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    print_r($response);
    echo '<br><br>';
    for ($i = 0; $i < count($response->CardReaderCfg->cardReaderFunction); $i++) {
      print_r($response->CardReaderCfg->cardReaderFunction[$i]);
      echo ' / ';
    }
    print_r($response->CardReaderCfg->cardReaderDescription);
    echo '<br>';
    print_r(($response->CardReaderCfg->enable) ? $response->CardReaderCfg->enable : 0);
    echo '<br>';
    print_r($response->CardReaderCfg->defaultVerifyMode);
    echo '<br>';
    print_r($response->CardReaderCfg->faceRecogizeInterval);
    echo '<br>';
    print_r($response->CardReaderCfg->independSwipeIntervals);
    echo '<br>';
    print_r(($response->CardReaderCfg->enableFailAlarm) ? $response->CardReaderCfg->enableFailAlarm : 0);
    echo '<br>';
    print_r($response->CardReaderCfg->maxReadCardFailNum);
    echo '<br>';
    print_r($response->CardReaderCfg->enableTamperCheck);
    echo '<br>';
    print_r(($response->CardReaderCfg->enableReverseCardNo) ? 1 : 0);
    echo '<br>';
  }
}
home($host);
function assistant($host)
{
  $url = "https://$host/ISAPI/AccessControl/CardReaderCfg/2?format=json";

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
    print_r($response->CardReaderCfg);
    echo '<br>';
    for ($i = 0; $i <= count($response->CardReaderCfg->cardReaderFunction); $i++) {
      print_r(isset($response->CardReaderCfg->cardReaderFunction[$i]) ? $response->CardReaderCfg->cardReaderFunction[$i] : '--');
      echo '<br>';
    }
    print_r($response->CardReaderCfg->cardReaderDescription);
    echo '<br>';
    print_r(($response->CardReaderCfg->enable) ? $response->CardReaderCfg->enable : 0);
    echo '<br>';

    print_r($response->CardReaderCfg->defaultVerifyMode);
    echo '<br>';
    print_r($response->CardReaderCfg->faceRecogizeInterval);
    echo '<br>';

    print_r(($response->CardReaderCfg->enableFailAlarm) ? $response->CardReaderCfg->enableFailAlarm : 0);
    echo '<br>';
    print_r($response->CardReaderCfg->maxReadCardFailNum);
    echo '<br>';
    print_r($response->CardReaderCfg->offlineCheckTime);
    echo '<br>';
    print_r($response->CardReaderCfg->pressTimeout);
    echo '<br>';

    print_r($response->CardReaderCfg->okLedPolarity);
    echo '<br>';
    print_r($response->CardReaderCfg->errorLedPolarity);
    echo '<br>';

    print_r(($response->CardReaderCfg->enableTamperCheck) ? 1 : 0);
    echo '<br>';
  }

  // Close cURL session
  curl_close($ch);
}
assistant($host);
