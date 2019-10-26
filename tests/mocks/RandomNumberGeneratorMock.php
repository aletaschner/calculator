<?php

use Calculator\Interfaces\IRandomNumberGenerator;

class RandomNumberGeneratorMock implements IRandomNumberGenerator {
    public function generate(){
        return 0;
    }
}