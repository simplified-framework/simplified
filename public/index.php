<?php

require dirname(__DIR__)."/vendor/autoload.php";
use Simplified\Http\Kernel;

$app = new Kernel();
$app->handleRequest();