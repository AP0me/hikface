<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function fetchSecurityToken($host)
{
  $url = "https://$host/ISAPI/Security/token?format=json";

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

  // Set headers including the cookie
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0",
    "Accept: */*",
    "Accept-Language: en-US,en;q=0.5",
    "If-Modified-Since: 0",
    "SessionTag: J7WI0ZB49GYDD5994A7ZCWDKLRWU9PNKEWIP3IFEPQHWQ5VV3DCC8J2JA3O1YSX1",
    "X-Requested-With: XMLHttpRequest",
    "Sec-Fetch-Dest: empty",
    "Sec-Fetch-Mode: cors",
    "Sec-Fetch-Site: same-origin",
    "Pragma: no-cache",
    "Cache-Control: no-cache",
    "Cookie: WebSession_1635328989=f5cba15402c942de70a48f2441e46dd5444d439be59560e38a0b88bc6354d664"
  ]);
  

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    return null;
  }

  // Close cURL session
  curl_close($ch);

  // Decode and return the JSON response
  return json_decode($response, true);
}

// Example usage
$securityToken = fetchSecurityToken($host);

if ($securityToken) {
  echo '<pre>' . json_encode($securityToken, JSON_PRETTY_PRINT) . '</pre>';
} else {
  echo "Failed to fetch the security token.";
}
?>
