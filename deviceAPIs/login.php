<?php

function computePasswordHash($password, $salt, $iterations) {
  $hash = $password;
  for ($i = 0; $i < $iterations; $i++) {
      $hash = hash('sha256', $hash . $salt);
  }
  return $hash;
}


function fetchSessionLoginCapabilities($host, $username, $random) {
    $url = "https://$host/ISAPI/Security/sessionLogin/capabilities?username=$username&random=$random";

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "User-Agent: Mozilla/5.0",
        "Accept: */*",
        "If-Modified-Since: 0",
        "X-Requested-With: XMLHttpRequest"
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
        return null;
    }
    curl_close($ch);
    return simplexml_load_string($response); // Parse XML response
}

function sessionLogin($host, $timestamp, $username, $password, $sessionID, $challenge, $salt, $iterations) {
    $url = "https://$host/ISAPI/Security/sessionLogin?timeStamp=$timestamp";

    // Compute hashed password
    $hashedPassword = computePasswordHash($password, $salt, $iterations);

    // Build XML body
    $xmlBody = <<<XML
<SessionLogin>
  <userName>$username</userName>
  <password>$hashedPassword</password>
  <sessionID>$sessionID</sessionID>
  <isSessionIDValidLongTerm>false</isSessionIDValidLongTerm>
  <sessionIDVersion>2</sessionIDVersion>
  <isNeedSessionTag>true</isNeedSessionTag>
</SessionLogin>
XML;

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlBody);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "User-Agent: Mozilla/5.0",
        "Accept: */*",
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        "If-Modified-Since: 0",
        "X-Requested-With: XMLHttpRequest"
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
        return null;
    }
    curl_close($ch);
    return $response;
}

$host = "192.168.0.116";
$username = "admin";
$password = "12345678m";
$random = "17081640";
$timestamp = time() * 1000;

// Step 1: Fetch session login capabilities
$capabilities = fetchSessionLoginCapabilities($host, $username, $random);

foreach ($capabilities as $key => $value) {
    echo "$key: json_encode($value)<br>";
}

if ($capabilities) {
    $sessionID = (string)$capabilities->sessionID;
    $challenge = (string)$capabilities->challenge;
    $salt = (string)$capabilities->salt;
    $iterations = (int)$capabilities->iterations;

    // Step 2: Attempt session login
    $response = sessionLogin($host, $timestamp, $username, $password, $sessionID, $challenge, $salt, $iterations);
    echo "Response for session login: <pre>" . htmlspecialchars($response) . "</pre>";
} else {
    echo "Failed to fetch session login capabilities.";
}
?>
