<?php
require_once ('../../plugins/security/HTMLPurifier.auto.php');
$config_security = HTMLPurifier_Config::createDefault();
$config_security->set('URI.HostBlacklist', array('google.com'));
$purifier = new HTMLPurifier($config_security);
?>