<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Eyewear\Command\InspectCommand;

$application = new Application('eyewear', '1.0.0');

$application->add(new InspectCommand());

$application->run();