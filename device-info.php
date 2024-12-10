<?php
class BasicInfo
{
  public $deviceName;
  public $language;
  public $model;
  public $serialNumber;
  public $firmwareVersion;
  public $encodingVersion;
  public $webVersion;
  public $pluginVersion;
  public $avaliableCameraCount;
  public $IOInputNumber;
  public $IOOutputNumber;
  public $lockNumber;
  public $localRS485Number;
  public $alarmInputCount;
  public $alarmOutputCount;
  public function __construct($deviceName, $language, $model, $serialNumber, $firmwareVersion, $encodingVersion, $webVersion, $pluginVersion, $avaliableCameraCount, $IOInputNumber, $IOOutputNumber, $lockNumber, $localRS485Number, $alarmInputCount, $alarmOutputCount){
    $this->deviceName = $deviceName;
    $this->language = $language;
    $this->model = $model;
    $this->serialNumber = $serialNumber;
    $this->firmwareVersion = $firmwareVersion;
    $this->encodingVersion = $encodingVersion;
    $this->webVersion = $webVersion;
    $this->pluginVersion = $pluginVersion;
    $this->avaliableCameraCount = $avaliableCameraCount;
    $this->IOInputNumber = $IOInputNumber;
    $this->IOOutputNumber = $IOOutputNumber;
    $this->lockNumber = $lockNumber;
    $this->localRS485Number = $localRS485Number;
    $this->alarmInputCount = $alarmInputCount;
    $this->alarmOutputCount = $alarmOutputCount;
  }
}
function fetchDeviceInfo($host)
{
  $url = "https://$host/ISAPI/System/deviceInfo?format=json";

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
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0",
    "Accept: */*",
    "Accept-Language: en-US,en;q=0.5",
    "If-Modified-Since: 0",
    "SessionTag: FD7BAAZAVY912N0N1N6EO6BC6YUWGDKE1CW4ETOVGIBQ8JVLO8JK8383YIXQIWDR",
    "X-Requested-With: XMLHttpRequest",
    "Pragma: no-cache",
    "Cache-Control: no-cache",
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    $xml = new SimpleXMLElement($response);
    // print_r((array)$xml);
    $basicInfo = new BasicInfo(
      (string)$xml->deviceName,
      'English',
      (string)$xml->model,
      (string)$xml->serialNumber,
      (string)$xml->firmwareVersion,
      (string)$xml->encoderVersion,
      'V5.1.27_R0401 build 230722',
      'V3.0.7.41',
      '1',
      '0',
      '0',
      (int)$xml->electroLockNum,
      (int)$xml->RS485Num,
      '0',
      (int)$xml->alarmOutNum,
    );
    return $basicInfo;
  }

  // Close cURL session
  curl_close($ch);
}
