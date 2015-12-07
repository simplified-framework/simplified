<?php

require dirname(__DIR__)."/app/bootstrap.php";
use Simplified\Http\Kernel;

$app = new Kernel();
$app->handleRequest();