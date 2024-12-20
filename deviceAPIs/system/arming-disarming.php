<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';
class DeployInfo
{
  public $ipAddr;
  public $deployNo;
  public $deployType;
  public function __construct($ipAddr, $deployNo, $deployType)
  {
    $this->ipAddr = $ipAddr;
    $this->deployNo = $deployNo;
    $this->deployType = $deployType;
  }
}
function fetchDeployInfo($host)
{
  $url = "https://$host/ISAPI/AccessControl/DeployInfo";

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

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    return xmlToJson($response)->DeployList->Content;
  }

  // Close cURL session
  curl_close($ch);
}

// Example usage
$deployInfoTMP = fetchDeployInfo($host);
// var_dump($deployInfoTMP);

$deployInfo = new DeployInfo(
  $deployInfoTMP->deployNo,
  $deployInfoTMP->deployType,
  $deployInfoTMP->ipAddr,
);
foreach ($deployInfo as $key => $value) {
  echo $key . ': ' . $value . '<br>';
}
