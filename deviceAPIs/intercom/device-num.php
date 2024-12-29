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
  $response = isAPI($url, 'GET');
  if(isset($response->error)){
    echo $response->error;
    return null;
  }
  return $response;
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

echo json_encode($deviceIDs);

