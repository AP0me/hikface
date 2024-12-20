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

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET

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
    return xmlToJson($response);
  }

  // Close cURL session
  curl_close($ch);
}

$relatedAddressData = fetchRelatedDeviceAddress($host);
$linkedNetwork = new LinkedNetwork(
  $relatedAddressData->unitType,
  explode('.', $relatedAddressData->SIPServerAddress->ipAddress),
  explode('.', $relatedAddressData->ManageAddress->ipAddress),
);

print_r(json_encode($linkedNetwork));
?>

<br><br>
<a href="linked-network-save.php?linkedNetwork=<?= htmlspecialchars(json_encode($linkedNetwork)); ?>">
  <button>Save</button>
</a>

