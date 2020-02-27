<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Eyewear\Command\CollectCommand;
use Symfony\Component\Console\Application;

$application = new Application('eyewear', '@git-version@');

$application->add(new CollectCommand());

$application->run();