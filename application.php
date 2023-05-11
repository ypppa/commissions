#!/usr/bin/env php
<?php
require __DIR__ . '/vendor/autoload.php';

use Ypppa\Commissions\Command\CalculateCommand;
use Symfony\Component\Console\Application;

$application = new Application('commissions', '1.0.0');
$command = new CalculateCommand();

$application->add($command);

$application->setDefaultCommand($command->getName(), true);
$application->run();