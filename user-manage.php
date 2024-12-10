<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';
class SecUser
{
  id,
  name,
  level,
}
function fetchSecurityUsers($host, $queryParams)
{
  $url = "https://$host/ISAPI/Security/users?$queryParams";
  return isAPIGet($url);
}

$queryParams = "security=1&iv=f3a4c0d14b477aa30667e31ad344d246";
$secUsers = fetchSecurityUsers($host, $queryParams);
print_r($secUsers);
