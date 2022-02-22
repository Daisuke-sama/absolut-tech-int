<?php

namespace App\CodeService\Extractor;

interface ExtractorInterface
{
    /**
     * @param  array  $options Anything helpful for the action
     *
     * @return array
     */
    public function extract(array $options): array;
}
