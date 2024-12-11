<?php

class AccessMethodCounts
{
  public $user;
  public $face = 0;
  public $fingerPrint = 0;
  public $card = 0;
  public function __construct($response) {
    for ($i = 0; $i < count($response->UserInfoSearch->UserInfo); $i++) {
      $currentUserInfo = $response->UserInfoSearch->UserInfo[$i];
      $this->fingerPrint += $currentUserInfo->numOfFP;
      $this->card += $currentUserInfo->numOfCard;
      $this->face += $currentUserInfo->numOfFace;
    }
    $this->user = count($response->UserInfoSearch->UserInfo);
  }
}



