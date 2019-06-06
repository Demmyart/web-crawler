<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class UrlService
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Getting full url to parse.
     *
     * @param string $url - url that we are going to begin crawling with
     * @param string $href - value of href attribute in <a> tag
     * @return string
     */
    public function getFullUrl(string $url, string $href): string
    {
        $originalHref = $href;
        /**
         * If it is a relative address
         */
        if (0 !== strpos($href, 'http')) {
            $path = '/' . ltrim($href, '/');
            $parts = parse_url($url);
            $href = $parts['scheme'] . '://';
            if (isset($parts['user']) && isset($parts['pass'])) {
                $href .= $parts['user'] . ':' . $parts['pass'] . '@';
            }
            $href .= $parts['host'];
            if (isset($parts['port'])) {
                $href .= ':' . $parts['port'];
            }
            $href .= '/' . ltrim($path, '/');

            $this->logger->debug('UrlService:relative_url_found', [
                'original_href' => $originalHref,
                'full_href'     => $href,
                'url_parts'         => $parts,
            ]);
        }

        return $href;
    }
}
