<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

class NetworkInfo
{
  public $autoNegotiation;
  public $speed;
  public $duplex;
  public $addressingType;
  public $ipv4;
  public $ipv4SubnetMask;
  public $ipv6Mode;
  public $ipv4Network;
  public $ipv6;
  public $ipv6BitMask;
  public $ipv6Address;
  public $MacAddress;
  public $MTU;
  public $DNSEnable;
  public $PrimaryDns;
  public $SecondaryDns;

  public function __construct($autoNegotiation, $speed, $duplex, $addressingType, $ipv4, $ipv4SubnetMask, $ipv4Network, $ipv6Mode, $ipv6, $ipv6BitMask, $ipv6Address, $MacAddress, $MTU, $DNSEnable,  $PrimaryDns, $SecondaryDns)
  {
    $this->autoNegotiation = $autoNegotiation;
    $this->speed = $speed;
    $this->duplex = $duplex;
    $this->addressingType = $addressingType;
    $this->ipv4 = $ipv4;
    $this->ipv4SubnetMask = $ipv4SubnetMask;
    $this->ipv4Network = $ipv4Network;
    $this->ipv6Mode = $ipv6Mode;
    $this->ipv6 = $ipv6;
    $this->ipv6BitMask = $ipv6BitMask;
    $this->ipv6Address = $ipv6Address;
    $this->MacAddress = $MacAddress;
    $this->MTU = $MTU;
    $this->DNSEnable = $DNSEnable;
    $this->PrimaryDns = $PrimaryDns;
    $this->SecondaryDns = $SecondaryDns;
  }
}
function fetchNetworkInterfaces($host)
{
  $url = "https://$host/ISAPI/System/Network/interfaces";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  $baseInfo = new NetworkInfo(
    (string)$response->NetworkInterface[0]->Link->autoNegotiation,
    (string)$response->NetworkInterface[0]->Link->speed,
    (string)$response->NetworkInterface[0]->Link->duplex,
    (string)$response->NetworkInterface[0]->IPAddress->addressingType,
    (string)$response->NetworkInterface[0]->IPAddress->ipAddress,
    (string)$response->NetworkInterface[0]->IPAddress->subnetMask,
    (string)$response->NetworkInterface[0]->IPAddress->DefaultGateway->ipAddress,
    (string)$response->NetworkInterface[0]->IPAddress->Ipv6Mode->ipV6AddressingType,
    (string)$response->NetworkInterface[0]->IPAddress->ipv6Address,
    (string)$response->NetworkInterface[0]->IPAddress->bitMask,
    (string)$response->NetworkInterface[0]->IPAddress->DefaultGateway->ipv6Address,
    (string)$response->NetworkInterface[0]->Link->MACAddress,
    (string)$response->NetworkInterface[0]->Link->MTU,
    (string)$response->NetworkInterface[0]->IPAddress->DNSEnable,
    (string)$response->NetworkInterface[0]->IPAddress->PrimaryDNS->ipAddress,
    (string)$response->NetworkInterface[0]->IPAddress->SecondaryDNS->ipAddress
  );
  return $baseInfo;
}

echo json_encode(fetchNetworkInterfaces($host));
