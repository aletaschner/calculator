<?php

namespace Calculator\Utils;

use Calculator\Interfaces\IRandomNumberGenerator;

class RandomNumberGenerator implements IRandomNumberGenerator {
    public function generate(){
        return mt_rand();
    }
}