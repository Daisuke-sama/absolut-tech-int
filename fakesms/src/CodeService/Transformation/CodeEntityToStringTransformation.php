<?php

namespace App\CodeService\Transformation;

use App\Entity\SmsCode;
use App\Model\CodeModel;

class CodeEntityToStringTransformation implements TransformationInterface
{
    /**
     * @param  array  $data  Single element array
     *
     * @return string
     */
    public function transform($data): string
    {
        if ( ! $data instanceof SmsCode) {
            throw new \InvalidArgumentException();
        }

        return sprintf('%s - %s', $data->getCell(), $data->getCode() );
    }
}
