<?php 
$host = '192.168.0.116';
// $host = 'vzuzntmyjpri.share.zrok.io';


// Confirm cookie is set
if (isset($_COOKIE['zrok_interstitial'])) {
  // echo "Cookie is set: " . $_COOKIE['zrok_interstitial'];
} else {
  setcookie("zrok_interstitial", "1", time() + (86400 * 30), "/");
}
