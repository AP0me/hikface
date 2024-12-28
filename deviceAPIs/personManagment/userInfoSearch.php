
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchAcsEvent($host)
{
  // URL for the API request
  $url = "https://$host/ISAPI/AccessControl/UserInfo/Search?format=json&security=1&iv=98116cf03555c48b8823f87d7e749a93";
  $data = json_encode([
    "UserInfoSearchCond" => reqBody()['UserInfoSearchCond'],
  ]);
  return isAPI($url, 'POST', $data);
}
echo json_encode(fetchAcsEvent($host));
