<?php

namespace App\MessageHandler;

use App\Message\CrawlTaskNotification;
use App\Repository\GrabInfoRepository;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use App\Service\CrawlerService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CrawlTaskHandler implements MessageHandlerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var CrawlerService
     */
    private $crawlerService;
    /**
     * @var GrabInfoRepository
     */
    private $grabInfoRepository;
    /**
     * @var SiteRepository
     */
    private $siteRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $entityManager,
        GrabInfoRepository $grabInfoRepository,
        SiteRepository $siteRepository,
        CrawlerService $crawlerService
    )
    {
        $this->logger = $logger;
        $this->crawlerService = $crawlerService;
        $this->grabInfoRepository = $grabInfoRepository;
        $this->siteRepository = $siteRepository;
        $this->entityManager = $entityManager;
    }

    public function __invoke(CrawlTaskNotification $message)
    {
        $this->logger->info('CrawlTaskHandler:got_a_task', ['id' => $message->getGrabInfoId()]);

        $grabInfo = $this->grabInfoRepository->find((int)$message->getGrabInfoId());
        $site = $this->siteRepository->find((int)$message->getSiteId());

        if (null === $grabInfo || null === $site) {
            $this->logger->warning('CrawlTaskHandler:either_site_or_grabInfo_is_null!', [
                'site' => var_export($site),
                'grabInfo' => var_export($grabInfo),
            ]);
        } else {
            $this->crawlerService->crawl(
                $grabInfo,
                $site->getUrl(),
                $site->getRestrictByUrl(),
                $grabInfo->getDepth()
            );
        }
        $grabInfo->incrementFinishedCouter();

        $this->entityManager->persist($grabInfo);
        $this->entityManager->flush();
        $this->crawlerService->reset();
    }
}
