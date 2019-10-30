<?php
// SILENT NOTICES
error_reporting(E_ALL & ~E_NOTICE);

// DATABASE SETTINGS
// ! CHANGE TO YOUR OWN !
define("MYSQL_HOST", "localhost");
define("MYSQL_NAME", "test");
define("MYSQL_CHAR", "utf8");
define("MYSQL_USER", "root");
define("MYSQL_PASS", "");

// AUTO PATH
define("PATH_LIB", __DIR__ . DIRECTORY_SEPARATOR);
?>