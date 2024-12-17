<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/deviceAPIs/video/channels.php';

class VideoStream
{
  public string $channelName;
  public string $streamType;
  public string $videoType;
  public string $resolution;
  public string $bitRateType;
  public string $videoQuality;
  public int $frameRateFps;
  public int $maxBitrateKbps;
  public string $videoEncoding;
  public int $frameInterval;

  public function __construct(
    string $channelName,
    string $videoType,
    string $resolution,
    string $bitRateType,
    string $videoQuality,
    int $frameRateFps,
    int $maxBitrateKbps,
    string $videoEncoding,
    int $frameInterval
  ) {
    $this->channelName = $channelName;
    $this->videoType = $videoType;
    $this->resolution = $resolution;
    $this->bitRateType = $bitRateType;
    $this->videoQuality = $videoQuality;
    $this->frameRateFps = $frameRateFps;
    $this->maxBitrateKbps = $maxBitrateKbps;
    $this->videoEncoding = $videoEncoding;
    $this->frameInterval = $frameInterval;
  }
}

$videoStreamData = streamingChannels($host);
$mainVideoStreamData = $videoStreamData[0];
$mainVideoStream = new VideoStream(
  $mainVideoStreamData->channelName,
  $mainVideoStreamData->Audio->enabled,
  $mainVideoStreamData->Video->videoResolutionWidth.'*'.$mainVideoStreamData->Video->videoResolutionHeight,
  $mainVideoStreamData->Video->videoQualityControlType,
  $mainVideoStreamData->Video->fixedQuality,
  $mainVideoStreamData->Video->GovLength,
  $mainVideoStreamData->Video->constantBitRate,
  $mainVideoStreamData->Video->videoCodecType,
  $mainVideoStreamData->Video->keyFrameInterval,
);
print_r('mainVideoStream: ');
print_r($mainVideoStream);
print_r('<br>');

$subVideoStreamData = $videoStreamData[1];
$subVideoStream = new VideoStream(
  $subVideoStreamData->channelName,
  $subVideoStreamData->Audio->enabled,
  $subVideoStreamData->Video->videoResolutionWidth.'*'.$subVideoStreamData->Video->videoResolutionHeight,
  $subVideoStreamData->Video->videoQualityControlType,
  $subVideoStreamData->Video->fixedQuality,
  $subVideoStreamData->Video->GovLength,
  $subVideoStreamData->Video->constantBitRate,
  $subVideoStreamData->Video->videoCodecType,
  $subVideoStreamData->Video->keyFrameInterval,
);
print_r('subVideoStream: ');
print_r($subVideoStream);

