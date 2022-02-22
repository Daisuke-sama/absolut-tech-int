<?php

namespace App\Handler;

use App\CodeService\Generator\GeneratorInterface;
use App\Entity\SmsCode;
use App\Model\CodeModel;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Exception\FeatureNotImplementedException;

class SmsSendHandler
{
    private GeneratorInterface $generator;
    private EntityManagerInterface $em;

    public function __construct(GeneratorInterface $generator, EntityManagerInterface $em)
    {
        $this->generator = $generator;
        $this->em = $em;
    }

    public function request(CodeModel $model): bool
    {
        // TODO implement with know API
        throw new FeatureNotImplementedException('Wait for the code, please.');
    }

    public function generateCode(): int
    {
        return $this->generator->generate();
    }

    public function saveCode(CodeModel $codeModel): void
    {
        $smsCode = new SmsCode();
        $smsCode->setCell($codeModel->cell);
        $smsCode->setCode($codeModel->code);
        $smsCode->setUpdatedAt(new \DateTime());
        $smsCode->setCreatedAt(new \DateTime());

        $this->em->persist($smsCode);
        $this->em->flush();
    }

    public function removeCode(CodeModel $codeModel)
    {
        // TODO 3rd. Implement after the connection with real SMS service implemented.
        throw new FeatureNotImplementedException('Implement after the connection with real SMS service implemented.');
    }
}
