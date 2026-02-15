<?php
$api_mytbk = "http://". $_SERVER['SERVER_NAME'] . "/tbk/api/set.php";
$acc_db = file_get_contents($api_mytbk);

define("DB_HOST", "localhost");
define("DB_NAME", $acc_db);
define("DB_USER", "mytbk");
define("DB_PASS", "admintbk");
