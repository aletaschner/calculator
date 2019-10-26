<?php

require_once('./vendor/autoload.php');
require_once('./src/utils/Database.php');
require_once('./src/interfaces/ICalculatorService.php');
require_once('./src/interfaces/IRandomNumberGenerator.php');
require_once('./src/services/CalculatorService.php');
require_once('./src/utils/RandomNumberGenerator.php');
require_once('./src/utils/InvalidCalculatorOperationException.php');
require_once('./src/models/Operation.php');

require_once('./tests/mocks/RandomNumberGeneratorMock.php');

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');