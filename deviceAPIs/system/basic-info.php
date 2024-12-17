<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/deviceAPIs/event-number.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/deviceAPIs/method-user-count.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/access-methods.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/deviceAPIs/system/project-config.php';
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
  public function __construct($deviceName, $language, $model, $serialNumber, $firmwareVersion, $encodingVersion, $webVersion, $pluginVersion, $avaliableCameraCount, $IOInputNumber, $IOOutputNumber, $lockNumber, $localRS485Number, $alarmInputCount, $alarmOutputCount)
  {
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
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

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
    $xml = new SimpleXMLElement($response);
    // print_r((array)$xml);
    $projectConfig = fetchProjectConfig($host);
    $basicInfo = new BasicInfo(
      (string)$xml->deviceName,
      'English',
      (string)$xml->model,
      (string)$xml->serialNumber,
      (string)$xml->firmwareVersion,
      (string)$xml->encoderVersion,
      $projectConfig->pluginVersion,
      $projectConfig->version,
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

$response = userAccessMethods($host);
$accessMethodCounts = new AccessMethodCounts($response);
$numberOfUsers = count($response->UserInfoSearch->UserInfo);
$numberOfEvents = fetchAcsEventTotalNum($host);

$parser = xml_parser_create();

print_r('DeviceInfo<br>');
$deviceInfo = fetchDeviceInfo($host);
foreach ($deviceInfo as $key => $value) {
  print_r('--' . $key . ': ' . $value . '<br>');
}
print_r(json_encode($numberOfUsers) . '<br>');
print_r(json_encode($accessMethodCounts) . '<br>');
print_r($numberOfEvents . '<br>');

$backURL = $_SERVER['PHP_SELF'];
?>

<form action="device-info-set.php" method="get">
  <input type="hidden" name="backURL" value="<?= $backURL ?>">
  <input type="text" name="device_name" class="Device Name" value="<?= $deviceInfo->deviceName ?>">
  <button type="submit">Save</button>
</form>

<label for="language-input">Language</label>
<select name="language" id="language-input">
  <option value="lang_id_0">English</option>
</select>
