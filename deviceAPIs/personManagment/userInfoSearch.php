
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchAcsEvent($host)
{
  // URL for the API request
  $url = "https://$host/ISAPI/AccessControl/UserInfo/Search?format=json&security=1&iv=98116cf03555c48b8823f87d7e749a93";
  // Initialize cURL session
  $ch = curl_init($url);
  $data = json_encode([
    "UserInfoSearchCond" => [
      "searchID" => "0baba6eab8f34b1697ba540a16b9096d",
      "maxResults" => 20,
      "searchResultPosition" => 0,
      "EmployeeNoList" => [
        ["employeeNo" => "a756b9a650f407e1abbade4da47322d1"]
      ]
    ]
  ]);
  echo json_encode($data);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);


  $ch = deviceAuth($ch);

  // Execute cURL request
  $response = json_decode(curl_exec($ch));

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    return $response;
  }
}
echo json_encode(fetchAcsEvent($host));
