<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

class SystemTime
{
  public $datetime;
  public $zone;
  public $syncMode;
  public function __construct($datetime, $zone, $syncMode)
  {
    $this->datetime = $datetime;
    $this->zone = $zone;
    $this->syncMode = $syncMode;
  }
}
function fetchSystemTime($host)
{
  $url = "https://$host/ISAPI/System/time";
  $response = isAPI($url, 'GET');
  if(isset($response->error)){
    return $response->error;
  }
  return $response;
}

$timeData = fetchSystemTime($host);
$systemTime = new SystemTime(
  $timeData->localTime,
  $timeData->timeZone,
  $timeData->timeMode
);

echo json_encode($systemTime);
?>
