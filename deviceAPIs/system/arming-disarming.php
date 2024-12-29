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
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  return $response->DeployList->Content;
}

// Example usage
$deployInfoTMP = fetchDeployInfo($host);
// var_dump($deployInfoTMP);

$deployInfo = new DeployInfo(
  $deployInfoTMP->deployNo,
  $deployInfoTMP->deployType,
  $deployInfoTMP->ipAddr,
);
echo json_encode($deployInfo);
