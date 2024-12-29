<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';
class SecUser{

}
function fetchSecurityUsers($host, $queryParams)
{
  $url = "https://$host/ISAPI/Security/users?$queryParams";
  $response = isAPI($url, 'GET');
  if(isset($response->error)){
    return $response->error;
  }
  return $response;
}

$queryParams = "security=1&iv=f3a4c0d14b477aa30667e31ad344d246";
echo json_encode(fetchSecurityUsers($host, $queryParams));
