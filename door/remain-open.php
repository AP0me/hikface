<?php require_once $_SERVER['DOCUMENT_ROOT'].'/hostname.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/door/door-command.php'; ?>
<?php
// Example usage
doorCommand($host, 'alwaysOpen', redirectURL: '../index.php?side=overview');
