<?php

namespace Calculator\Services;

use Calculator\Utils\InvalidCalculatorOperationException;
use Calculator\Interfaces\ICalculatorService;
use Calculator\Interfaces\IRandomNumberGenerator;

class CalculatorService implements ICalculatorService {

    private $numberGenerator;
    public function setNumberGenerator(IRandomNumberGenerator $generator){
        $this->numberGenerator = $generator;
        return $this;
    }
    
    public function calculate(string $operation){
        $elements = explode(" ", $operation);
        
        for($i = 0; $i+2 <= count($elements); $i+=2){
            $result = $this->doMath(floatval($result ?? $elements[$i]), $elements[$i+1], floatval($elements[$i+2]));
        }

        return $result;
    }

    public function generateBonus(float $result){
        return ($this->numberGenerator->generate() == $result) ? 1 : 0;
    }

    private function doMath(float $left, string $op, float $right){
        switch($op){
            case '+':
                return $left + $right;
            case '-':
                return $left - $right;
            case '*':
                return $left * $right;
            case '/':
                $this->avoidZeroOperations($left, $right);
                return $left / $right;
            case 'MOD':
                $this->avoidZeroOperations($left, $right);
                return $left % $right;
        }
    }

    private function avoidZeroOperations(float $left, float $right){
        if($left == 0 || $right == 0)
            throw new InvalidCalculatorOperationException('Divison by Zero');
    }

}