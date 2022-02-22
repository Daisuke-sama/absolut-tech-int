<?php

namespace App\CodeService\Extractor;

use App\Repository\SmsCodeRepository;

class CodeListExtractor implements ExtractorInterface
{
    private SmsCodeRepository $codeRepository;

    public function __construct(SmsCodeRepository $codeRepository)
    {
        $this->codeRepository = $codeRepository;
    }

    /**
     * All from the database
     *
     * @inheritDoc
     */
    public function extract(array $options = []): array
    {
        return $this->codeRepository->findAll();
    }
}
