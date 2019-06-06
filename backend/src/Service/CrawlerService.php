<?php

namespace App\Service;

use App\Entity\GrabInfo;
use Psr\Log\LoggerInterface;

class CrawlerService
{
    protected $seen = [];
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var InfoGrabberService
     */
    private $infoGrabberService;
    /**
     * @var UrlService
     */
    private $urlService;

    public function __construct(
        LoggerInterface $logger,
        InfoGrabberService $infoGrabberService,
        UrlService $urlService
    )
    {
        $this->logger = $logger;
        $this->infoGrabberService = $infoGrabberService;
        $this->urlService = $urlService;
    }

    /**
     * @param GrabInfo $grabInfo
     * @param string $url - url that we are going to begin crawling with
     * @param string $restrictByUrl - restricting the crawling by url
     * @param int $depth - how many pages to crawl
     */
    public function crawl(GrabInfo $grabInfo, string $url, string $restrictByUrl, int $depth)
    {
        $this->logger->debug('CrawlerService:starting_crawling_for ' . $url, [
            'depth' => $depth,
            'restrictByUrl' => $restrictByUrl,
            '$grabInfo.id' => $grabInfo->getId(),
        ]);

        if (isset($this->seen[$url]) || $depth === 0) {
            return;
        }

        $this->seen[$url] = true;

        $dom = new \DOMDocument('1.0');
        @$dom->loadHTMLFile($url);

        $this->infoGrabberService->grab($grabInfo, $dom, $url);

        $anchors = $dom->getElementsByTagName('a');
        foreach ($anchors as $element) {
            $href = $this->urlService->getFullUrl($url, $element->getAttribute('href'));

            if (0 === strpos($href, $restrictByUrl)) {
                $this->logger->debug('CrawlerService:next_url_info', [
                    'href' => $href,
                ]);
                $href = $this->canonicalizeUrl($href);
                $this->crawl($grabInfo, $href, $restrictByUrl, $depth - 1);
            }
        }
        unset($dom);
    }

    public function reset()
    {
        $this->seen = [];
    }

    protected function canonicalizeUrl(string $url)
    {
        $url = explode('/', $url);
        $keys = array_keys($url, '..');

        foreach($keys as $keypos => $key)
        {
            array_splice($url, $key - ($keypos * 2 + 1), 2);
        }

        $url = implode('/', $url);
        return str_replace('./', '', $url);
    }
}
