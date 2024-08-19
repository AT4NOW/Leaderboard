<?php
require_once 'config.php'; // config check: debug true? then:

if ($debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
?>
