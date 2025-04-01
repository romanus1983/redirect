<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Core;

$core = Core::getInstance();
$core->initializeModules();
$core->dispatch();
