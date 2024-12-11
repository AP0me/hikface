<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/content/video/channels.php';

class AudioSettings
{
  public string $audioEncoding;
  public int $inputVolume;
  public int $outputVolume;
  public bool $enableVoicePrompt;

  public function __construct(
    string $audioEncoding,
    int $inputVolume,
    int $outputVolume,
    bool $enableVoicePrompt
  ) {
    $this->audioEncoding = $audioEncoding;
    $this->inputVolume = $inputVolume;
    $this->outputVolume = $outputVolume;
    $this->enableVoicePrompt = $enableVoicePrompt;
  }
}

$audioStreamData = streamingChannels($host);
$mainAudioStreamData = $audioStreamData[0];
$subAudioStreamData = $audioStreamData[1];
$mainAudioStream = new AudioSettings(
  $mainAudioStreamData->Audio->audioCompressionType,
  0,
  0,
  $mainAudioStreamData->Audio->enabled,
);
var_dump($mainAudioStream);


