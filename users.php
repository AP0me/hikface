<?php

function searchUsers($host, $username, $password, $searchConditions)
{
  $url = "https://$host/ISAPI/Security/users/search?format=json";

  $data = json_encode($searchConditions);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

  // Add Digest Authentication
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Add headers
  $headers = [
    "Content-Type: application/json",
    "Accept: application/json",
    "skip_zrok_interstitial: 1",
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Enable verbose mode for debugging
  curl_setopt($ch, CURLOPT_VERBOSE, true);

  $response = curl_exec($ch);

  // Check for cURL errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    curl_close($ch);
    return null;
  }

  // Close cURL session
  curl_close($ch);

  // Log raw response for debugging
  echo "Raw Response: " . htmlspecialchars($response);

  // Decode JSON response
  $json = json_decode($response, true);

  if ($json === null) {
    echo "Failed to decode JSON response.";
    return null;
  }

  return $json;
}

// Example usage
$host = "z5cs9h4fhqka.share.zrok.io";
$username = "admin";
$password = "12345678m";

$searchConditions = [
  "UserSearchCond" => [
    "searchID" => "exampleSearchID",
    "searchResultPosition" => 0,
    "maxResults" => 20,
  ]
];

$response = searchUsers($host, $username, $password, $searchConditions);

if ($response) {
  echo "<pre>";
  print_r($response);
  echo "</pre>";
} else {
  echo "Failed to search users.";
}
