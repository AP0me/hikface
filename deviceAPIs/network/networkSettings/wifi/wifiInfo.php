<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

class WifiInfo
{
  public $addressingType;
  public $ipAddress;
  public $subnetMask;
  public $ipAddressGateway;
  public $ipv6Mode;
  public $ipv6Address;
  public $bitMask;
  public $ipv6AddressGateway;
  public $DNSEnable;
  public $PrimaryDns;
  public $SecondaryDns;

  public function __construct($addressingType, $ipAddress, $subnetMask, $ipAddressGateway, $ipv6Mode, $ipv6Address, $bitMask, $ipv6AddressGateway, $DNSEnable,  $PrimaryDns, $SecondaryDns)
  {
    $this->addressingType = $addressingType;
    $this->ipAddress = $ipAddress;
    $this->subnetMask = $subnetMask;
    $this->ipAddressGateway = $ipAddressGateway;
    $this->ipv6Mode = $ipv6Mode;
    $this->ipv6Address = $ipv6Address;
    $this->bitMask = $bitMask;
    $this->ipv6AddressGateway = $ipv6AddressGateway;
    $this->DNSEnable = $DNSEnable;
    $this->PrimaryDns = $PrimaryDns;
    $this->SecondaryDns = $SecondaryDns;
  }
}
function fetchNetworkInterfaces($host)
{
  // URL of the resource
  $url = "https://$host/ISAPI/System/Network/interfaces/2/ipAddress";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  $wifiInfo = new WifiInfo(
    (string)$response->addressingType,
    (string)$response->ipAddress,
    (string)$response->subnetMask,
    (string)$response->DefaultGateway->ipAddress,
    (string)$response->Ipv6Mode->ipV6AddressingType,
    (string)$response->ipv6Address,
    (string)$response->bitMask,
    (string)$response->DefaultGateway->ipv6Address,
    (string)$response->DNSEnable,
    (string)$response->PrimaryDNS->ipAddress,
    (string)$response->SecondaryDNS->ipAddress,

  );
  return $wifiInfo;
}

echo json_encode(fetchNetworkInterfaces($host));
