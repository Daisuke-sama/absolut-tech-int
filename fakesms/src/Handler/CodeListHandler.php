<?php

namespace App\Handler;

use App\CodeService\Extractor\ExtractorInterface;
use App\CodeService\Transformation\TransformationInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CodeListHandler
{
    private ExtractorInterface $listExtractor;
    private TransformationInterface $transformation;
    private SerializerInterface $serializer;

    public function __construct(ExtractorInterface $listExtractor, TransformationInterface $transformation, SerializerInterface $serializer)
    {
        $this->listExtractor  = $listExtractor;
        $this->transformation = $transformation;
        $this->serializer     = $serializer;
    }

    /**
     * @return string JSON
     */
    public function getCodeList(): string
    {
        $codeObjects = $this->listExtractor->extract();

        $codes = [];
        foreach ($codeObjects as $code) {
            $codes[] = $this->transformation->transform($code);
        }

        return $this->serializer->serialize($codes, 'json');
    }
}
