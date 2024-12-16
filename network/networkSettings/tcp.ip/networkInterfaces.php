<?php
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
  
  public function __construct($autoNegotiation, $speed, $duplex, $addressingType, $ipv4, $ipv4SubnetMask, $ipv4Network, $ipv6Mode, $ipv6, $ipv6BitMask, $ipv6Address, $MacAddress, $MTU, $DNSEnable,  $PrimaryDns, $SecondaryDns){
    $this->autoNegotiation=$autoNegotiation;
    $this->speed=$speed;
    $this->duplex=$duplex;
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
function fetchNetworkInterfaces($host) {
    $url = "https://$host/ISAPI/System/Network/interfaces";

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
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    } else {
        $xml = new SimpleXMLElement($response);
        print_r($xml);
        echo '<br><br>';
        $baseInfo = new NetworkInfo(
            (string)$xml->NetworkInterface[0]->Link->autoNegotiation,
            (string)$xml->NetworkInterface[0]->Link->speed,
            (string)$xml->NetworkInterface[0]->Link->duplex,
            (string)$xml->NetworkInterface[0]->IPAddress->addressingType,
            (string)$xml->NetworkInterface[0]->IPAddress->ipAddress,
            (string)$xml->NetworkInterface[0]->IPAddress->subnetMask,
            (string)$xml->NetworkInterface[0]->IPAddress->DefaultGateway->ipAddress,
            (string)$xml->NetworkInterface[0]->IPAddress->Ipv6Mode->ipV6AddressingType,
            (string)$xml->NetworkInterface[0]->IPAddress->ipv6Address,
            (string)$xml->NetworkInterface[0]->IPAddress->bitMask,
            (string)$xml->NetworkInterface[0]->IPAddress->DefaultGateway->ipv6Address,     
            (string)$xml->NetworkInterface[0]->Link->MACAddress,
            (string)$xml->NetworkInterface[0]->Link->MTU,
            (string)$xml->NetworkInterface[0]->IPAddress->DNSEnable,
            (string)$xml->NetworkInterface[0]->IPAddress->PrimaryDNS->ipAddress,
            (string)$xml->NetworkInterface[0]->IPAddress->SecondaryDNS->ipAddress
          );
          return $baseInfo;
    }
    curl_close($ch);
}
$a=fetchNetworkInterfaces("192.168.0.116");
print_r($a);