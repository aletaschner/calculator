<?php

namespace Calculator\Interfaces;

interface ICalculatorService {
    function calculate(string $operation);
    function generateBonus(float $result);
    function setNumberGenerator(IRandomNumberGenerator $generator);
}