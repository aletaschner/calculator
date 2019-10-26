<?php

use Calculator\Interfaces\ICalculatorService;
use Calculator\Interfaces\IRandomNumberGenerator;
use Calculator\Utils\RandomNumberGenerator;
use Calculator\Services\CalculatorService;
use Calculator\Utils\InvalidCalculatorOperationException;
use PHPUnit\Framework\TestCase;



class CalculatorServiceTest extends TestCase {

    protected $service;

    public function setUp(): void{
        $this->service = (new CalculatorService())->setNumberGenerator(new RandomNumberGenerator());
    }

    public function testShouldAdd(){
        $operation = "10 + 10";
        $result = $this->service->calculate($operation);

        $this->assertEquals(20, $result);
    }

    public function testShouldSubtract(){
        $operation = "10 - 5";
        $result = $this->service->calculate($operation);

        $this->assertEquals(5, $result);
    }

    public function testShouldMultiply(){
        $operation = "10 * 5";
        $result = $this->service->calculate($operation);

        $this->assertEquals(50, $result);
    }

    public function testShouldDivide(){
        $operation = "10 / 2";
        $result = $this->service->calculate($operation);

        $this->assertEquals(5, $result);
    }

    public function testShouldMod(){
        $operation = "10 MOD 2";
        $result = $this->service->calculate($operation);

        $this->assertEquals(0, $result);
    }

    public function testShouldNotDivideByZero(){
        $operation = "2 / 0";
        $this->expectException(InvalidCalculatorOperationException::class);        
        $result = $this->service->calculate($operation);
    }

    public function testShouldDoComplexOperations(){
        $operation = "2 + 2 * 2 / 2 MOD 2";
        $result = $this->service->calculate($operation);

        $this->assertEquals(0, $result);
    }

    public function testShouldDefineBonusAsOneWhenEqual(){
        $operation = "2 + 2 * 2 / 2 MOD 2";
        $result = $this->service->calculate($operation);

        $mock = new RandomNumberGeneratorMock();
        $this->service->setNumberGenerator($mock);

        $this->assertEquals(1, $this->service->generateBonus($result));
    }

    public function testShouldNotDivideByZeroAsExample(){
        $operation = "5 + 1 MOD 5 / 0";
        $this->expectException(InvalidCalculatorOperationException::class);        
        $result = $this->service->calculate($operation);
    }

    public function testShouldSolveExamples(){
        $operations = [
            '1 + 2 * 3' => 9,
            '1 - 1 * 1 + 3' => 3,
            '2 / 2 * 3 + 1 - 1' => 3,
            '5 + 3 * 5' => 40,
            '5 + 1 MOD 2' => 0
        ];

        foreach($operations as $k=>$v){
            $this->assertEquals($this->service->calculate($k), $v);
        }
    }
}