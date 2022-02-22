<?php

namespace App\SmsService\Tester;

use App\Exception\SmsServiceException;
use App\Model\SmsCheckRequestModel;
use App\Model\SmsCheckResponseModel;
use App\SmsService\Converter\ConverterInterface;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class SmsCodeFinder
{
    private HttpClientInterface $httpClient;
    private ConverterInterface $converter;

    public function __construct(HttpClientInterface $httpClient, ConverterInterface $converter)
    {
        $this->httpClient = $httpClient;
        $this->converter = $converter;
    }

    public function find(string $code): SmsCheckResponseModel
    {
        $dto = new SmsCheckRequestModel();
        $dto->code = $code;
        $dto->checkingDatetime = new \DateTime();

        $response = $this->httpClient->request("POST", env('FAKESMS_BASE_URI').'/find', ['json' => $dto,]);

        try {
            $json = $response->getContent();
        } catch (TransportException $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            throw new SmsServiceException('Checking route was not found or SMS server failed.');
        }

        $responseModel = $this->converter->convert($json);

        return $responseModel;
    }
}
