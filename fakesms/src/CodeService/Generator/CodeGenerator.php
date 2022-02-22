<?php

namespace App\CodeService\Generator;

class CodeGenerator implements GeneratorInterface
{
    public function generate()
    {
        return random_int(10000, 99999);
    }
}
