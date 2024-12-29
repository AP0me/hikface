<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

class ScreenDisplayPreference
{
  public bool $sleep;
  public int $sleepAfter;
  public string $themeMode;
  public function __construct(
    $sleep,
    $sleepAfter,
    $themeMode,
  ) {
    $this->sleep = $sleep;
    $this->sleepAfter = $sleepAfter;
    $this->themeMode = $themeMode;
  }
}

function fetchIdentityTerminal($host)
{
  $url = "https://$host/ISAPI/AccessControl/IdentityTerminal";
  $response = isAPI($url, 'GET');
  if (isset($response->error)) {
    echo json_encode($response->error);
    return null;
  }
  return $response;
}

// Example usage
$identityTerminal = fetchIdentityTerminal($host);
$screenDisplayPreference = new ScreenDisplayPreference(
  $identityTerminal->enableScreenOff,
  $identityTerminal->screenOffTimeout,
  $identityTerminal->showMode,
);

echo json_encode($screenDisplayPreference);
?>


