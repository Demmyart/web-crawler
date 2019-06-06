<?php

namespace App\Message;


class CrawlTaskNotification
{
    /**
     * @var int
     */
    private $grabInfoId;
    /**
     * @var int
     */
    private $siteId;

    /**
     * CrawlTaskNotification constructor.
     * @param int $grabInfoId
     * @param int $siteId
     */
    public function __construct(int $grabInfoId, int $siteId)
    {
        $this->grabInfoId = $grabInfoId;
        $this->siteId = $siteId;
    }

    /**
     * @return int
     */
    public function getGrabInfoId(): int
    {
        return $this->grabInfoId;
    }

    /**
     * @return int
     */
    public function getSiteId(): int
    {
        return $this->siteId;
    }
}
