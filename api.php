<?php

namespace Calculator;

// requires needed modules
require_once('config.php');

use Calculator\Utils\Database;
use Calculator\Models\Operation;
use Calculator\Utils\InvalidCalculatorOperationException;
use Calculator\Services\CalculatorService;
use Calculator\Utils\RandomNumberGenerator;

// gets request content and sets content-type
$req = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json');

$randomGenerator = new RandomNumberGenerator();
$service = (new CalculatorService())->setNumberGenerator($randomGenerator);

$op = (new Operation())
        ->setOperation($req['operation'])
        ->setIp($_SERVER['REMOTE_ADDR'])
        ->setTimestamp(time());

try {
    $result = $service->calculate($req['operation']);
    $op = $op->setResult($result)
             ->setBonus($service->generateBonus($result));
} catch(InvalidCalculatorOperationException $e){
    $op->setResult('ERR');
    http_response_code(400);
} catch(Exception $e){
    $op->setResult('ERR');
    http_response_code(400);
}

$op = $op->save();
die(json_encode($op));