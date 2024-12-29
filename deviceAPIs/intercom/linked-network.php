<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

class LinkedNetwork{
  public string $deviceType;
  public array $serverIPAddress;
  public array $stationIPAddress;

  public function __construct($deviceType, $serverIPAddress, $stationIPAddress){
    $this->deviceType = $deviceType;
    $this->serverIPAddress = $serverIPAddress;
    $this->stationIPAddress = $stationIPAddress;
  }
}

function fetchRelatedDeviceAddress($host)
{
  $url = "https://$host/ISAPI/VideoIntercom/relatedDeviceAddress";
  $response = isAPI($url, 'GET');
  if(isset($response->error)){
    echo $response->error;
    return null;
  }
  return $response;
}

$relatedAddressData = fetchRelatedDeviceAddress($host);
$linkedNetwork = new LinkedNetwork(
  $relatedAddressData->unitType,
  explode('.', $relatedAddressData->SIPServerAddress->ipAddress),
  explode('.', $relatedAddressData->ManageAddress->ipAddress),
);

echo json_encode($linkedNetwork);

