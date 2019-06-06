<?php

namespace App\Service;

use App\Dto\GrabResultDto;
use App\Entity\GrabResult;
use Psr\Log\LoggerInterface;

class GrabResultService
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function convertToDtoWithoutInfo(GrabResult $grabResult): GrabResultDto
    {
        $resultDto = new GrabResultDto();
        $resultDto->id = $grabResult->getId();
        $resultDto->url = $grabResult->getUrl();
        $resultDto->context = htmlentities($grabResult->getContext());

        return $resultDto;
    }
}
