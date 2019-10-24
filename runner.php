<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

include __DIR__ . '/src/Store.class.php';

$store = new Store();
$store->run();
