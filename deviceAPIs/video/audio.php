<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/deviceAPIs/video/channels.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/deviceAPIs/video/volume.php';

class AudioSettings
{
  public int $audioInputChannelID;
  public int $audioOutputChannelID;
  public string $audioEncoding;
  public int $inputVolume;
  public int $outputVolume;
  public bool $enableVoicePrompt;

  public function __construct(
    int $audioInputChannelID,
    int $audioOutputChannelID,
    string $audioEncoding,
    int $inputVolume,
    int $outputVolume,
    bool $enableVoicePrompt
  ) {
    $this->audioInputChannelID = $audioInputChannelID;
    $this->audioOutputChannelID = $audioOutputChannelID;
    $this->audioEncoding = $audioEncoding;
    $this->inputVolume = $inputVolume;
    $this->outputVolume = $outputVolume;
    $this->enableVoicePrompt = $enableVoicePrompt;
  }
}

$volumeIn = fetchAudioVolume($host, 'in');
$volumeOut = fetchAudioVolume($host, 'out');
$audioStreamData = streamingChannels($host);
$mainAudioStreamData = $audioStreamData[0];
$subAudioStreamData = $audioStreamData[1];

$mainAudioStream = new AudioSettings(
  $mainAudioStreamData->Audio->audioInputChannelID,
  $mainAudioStreamData->Audio->audioInputChannelID,
  $mainAudioStreamData->Audio->audioCompressionType,
  $volumeIn,
  $volumeOut,
  $mainAudioStreamData->Audio->enabled,
);

print_r(json_encode($mainAudioStream));


