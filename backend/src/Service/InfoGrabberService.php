<?php

namespace App\Service;

use App\Entity\GrabInfo;
use App\Entity\GrabResult;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class InfoGrabberService implements InfoGrabberServiceInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    const CONTEXT_SIZE = 60;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var SiteService
     */
    private $siteService;

    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $entityManager,
        SiteService $siteService
    )
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        $this->siteService = $siteService;
    }

    public function grab(GrabInfo $grabInfo, \DOMDocument $dom, string $url): int
    {
        $this->logger->debug('InfoGrabberService:started_grabbing');

        $resultsCount = 0;

        $html = $dom->saveHTML();

        $offset = 0;

        $occurrence = $grabInfo->getUsername();

        while (
            $offset <= strlen($html)
            && false !== ($pos = strpos($html, $occurrence, $offset))
        ) {
            $resultsCount++;

            $offset = $offset + $pos + strlen($occurrence);

            $startPos = max($pos - round(self::CONTEXT_SIZE / 2), 0);

            $grabResult = new GrabResult();
            $grabResult->setContext(substr($html, $startPos, self::CONTEXT_SIZE + strlen($occurrence)));
            $grabResult->setUrl($url);
            $grabResult->setGrabInfo($grabInfo);

            $this->entityManager->persist($grabResult);

            $this->logger->debug('InfoGrabberService:found_occurrence', [
                'context' => $grabResult->getContext(),
                'occurrence' => $occurrence,
                'current_offset' => $offset,
            ]);
        }
        $this->entityManager->flush();

        return $resultsCount;
    }
}
