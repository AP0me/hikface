<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

class DeviceIDs
{
  public string $deviceType;
  public int $floorNumber;
  public int $deviceIndex;
  public int $communityNumber;
  public int $buildingNumber;
  public int $unitNumber;
  public function __construct($deviceType, $floorNumber, $deviceIndex, $communityNumber, $buildingNumber, $unitNumber)
  {
    $this->deviceType = $deviceType;
    $this->floorNumber = $floorNumber;
    $this->deviceIndex = $deviceIndex;
    $this->communityNumber = $communityNumber;
    $this->buildingNumber = $buildingNumber;
    $this->unitNumber = $unitNumber;
  }
}

function fetchDeviceId($host)
{
  $url = "https://$host/ISAPI/VideoIntercom/deviceId";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

  $ch = deviceAuth($ch);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    return xmlToJson($response);
  }

  // Close cURL session
  curl_close($ch);
}

$deviceIDData = fetchDeviceId($host);
$deviceIDs = new DeviceIDs(
  $deviceIDData->unitType,
  (int)$deviceIDData->floorNumber,
  (int)$deviceIDData->deviceIndex,
  (int)$deviceIDData->periodNumber,
  (int)$deviceIDData->buildingNumber,
  (int)$deviceIDData->unitNumber,
);

print_r($deviceIDs);
?>
<br><br>
<a href="device-num-save.php?deviceIDs=<?= htmlspecialchars(json_encode($deviceIDs)); ?>">
  <button>Save</button>
</a>
