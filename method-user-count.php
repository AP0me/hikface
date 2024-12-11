<?php

class NumberOfUsersWithAccessMethod
{
  public $user = 0;
  public $face = 0;
  public $fingerPrint = 0;
  public $card = 0;
  public function __construct($response) {
    for ($i = 0; $i < count($response->UserInfoSearch->UserInfo); $i++) {
      $currentUserInfo = $response->UserInfoSearch->UserInfo[$i];
      if ($currentUserInfo->numOfFace != 0) {
        $this->face += 1;
      }
      if ($currentUserInfo->numOfCard != 0) {
        $this->card += 1;
      }
      if ($currentUserInfo->numOfFP != 0) {
        $this->fingerPrint += 1;
      }
    }
    $this->user = count($response->UserInfoSearch->UserInfo);
  }
}

function userAccessMethods($host)
{
  $url = "https://$host/ISAPI/AccessControl/UserInfo/Search?format=json&security=1&iv=126193887ffb915737e0c76173e18f83";
  $data = json_encode([
    "UserInfoSearchCond" => [
      "searchID" => "7323fd9b3a9c4f4ba427384263a8eb14",
      "maxResults" => 20,
      "searchResultPosition" => 0
    ]
  ]);
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
  $headers = [
    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0",
    "Accept: */*",
    "Accept-Language: en-US,en;q=0.5",
    "If-Modified-Since: 0",
    "SessionTag: WIF1HDYXZHMY3SYCYFKDGN7N7QU5TSKFESKVK18OOCUSXVAJFTA9TIIXHELXZIND",
    "X-Requested-With: XMLHttpRequest",
    "Pragma: no-cache",
    "Cache-Control: no-cache"
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $response = json_decode(curl_exec($ch));
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    return $response;
  }
}
