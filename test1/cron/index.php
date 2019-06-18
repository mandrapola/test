<?php

require 'Cron.php';
header('Content-Type: application/json');
$cron = new Cron();
$cron->run();
