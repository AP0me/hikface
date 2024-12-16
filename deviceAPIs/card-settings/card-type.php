<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';

function fetchRFCardConfiguration($host)
{
  $url = "https://$host/ISAPI/AccessControl/Configuration/RFCardCfg?format=json";

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
    return json_decode($response);
  }

  // Close cURL session
  curl_close($ch);
}

$RFCardCfg = fetchRFCardConfiguration($host)->RFCardCfg;

foreach ($RFCardCfg as $card) {
  var_dump(json_encode($card).'<br>');
}

?>

<br><br>
<a href="card-type-save.php?RFCardCfg=<?= htmlspecialchars(json_encode($RFCardCfg)); ?>">
  <button>Save</button>
</a>

