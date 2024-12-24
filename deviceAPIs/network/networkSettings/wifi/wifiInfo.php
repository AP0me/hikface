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

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET

  $ch = deviceAuth($ch);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {

    $xml = new SimpleXMLElement($response);


    $wifiInfo = new WifiInfo(
      (string)$xml->addressingType,
      (string)$xml->ipAddress,
      (string)$xml->subnetMask,
      (string)$xml->DefaultGateway->ipAddress,
      (string)$xml->Ipv6Mode->ipV6AddressingType,
      (string)$xml->ipv6Address,
      (string)$xml->bitMask,
      (string)$xml->DefaultGateway->ipv6Address,
      (string)$xml->DNSEnable,
      (string)$xml->PrimaryDNS->ipAddress,
      (string)$xml->SecondaryDNS->ipAddress,

    );
    return $wifiInfo;
  }

  // Close cURL session
  curl_close($ch);
}

// Example usage
$a = fetchNetworkInterfaces($host);
print_r($a);
