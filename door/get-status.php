<?php require_once $_SERVER['DOCUMENT_ROOT'].'/hostname.php'; ?>
<?php
function fetchAcsWorkStatus($host)
{
  $url = "https://$host/ISAPI/AccessControl/AcsWorkStatus?format=json";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Set headers
  $headers = [
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0",
    "Accept: */*",
    "Accept-Language: en-US,en;q=0.5",
    "If-Modified-Since: 0",
    "SessionTag: 7SMBMXYB2RUYETU8LF4P2NQIFQGA7GNGO0LQ2T8H9JX434KTB4BHTK4QLUA16V1P",
    "X-Requested-With: XMLHttpRequest",
    "Pragma: no-cache",
    "Cache-Control: no-cache",
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  }
  else {
    $doorLockStatus = json_decode($response)->AcsWorkStatus;
    return $doorLockStatus->doorStatus[0];
  }

  // Close cURL session
  curl_close($ch);
}

