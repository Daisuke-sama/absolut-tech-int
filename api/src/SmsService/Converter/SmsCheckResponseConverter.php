<?php

namespace App\SmsService\Converter;

use App\Model\SmsCheckResponseModel;
use Symfony\Component\Serializer\SerializerInterface;

class SmsCheckResponseConverter implements ConverterInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function convert(string $data): SmsCheckResponseModel
    {
        $decoded = $this->serializer->deserialize($data, SmsCheckResponseModel::class, 'json');

        return $decoded;
    }
}
