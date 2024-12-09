<?php 
// $host = 'z5cs9h4fhqka.share.zrok.io';
$host = '192.168.0.116';

setcookie("zrok_interstitial", "1", time() + (86400 * 30), "/");

// Confirm cookie is set
if (isset($_COOKIE['zrok_interstitial'])) {
  // echo "Cookie is set: " . $_COOKIE['zrok_interstitial'];
} else {
  echo "Cookie is not set yet.";
}
