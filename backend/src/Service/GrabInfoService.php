<?php

namespace App\Service;

use App\Dto\GrabInfoDto;
use App\Dto\SiteDto;
use App\Entity\GrabInfo;

class GrabInfoService
{
    public function convertToDto(GrabInfo $grabInfo): GrabInfoDto
    {
        $grabInfoDto = new GrabInfoDto();
        $grabInfoDto->id = $grabInfo->getId();
        $grabInfoDto->username = $grabInfo->getUsername();
        $grabInfoDto->email = $grabInfo->getEmail();
        $grabInfoDto->band = $grabInfo->getBand();
        $grabInfoDto->finishedUrlsCounter = $grabInfo->getFinishedUrlsCounter();

        $siteDtos = [];

        foreach ($grabInfo->getSites() as $site) {
            $siteDto = new SiteDto();
            $siteDto->id = $site->getId();
            $siteDto->url = $site->getUrl();
            $siteDtos[] = $siteDto;
        }
        $grabInfoDto->sites = $siteDtos;

        return $grabInfoDto;
    }

    public function convertToEntityFromDto(GrabInfoDto $grabInfoDto): GrabInfo
    {
        $grabInfo = new GrabInfo();
        $grabInfo->setUsername($grabInfoDto->username);
        $grabInfo->setBand($grabInfoDto->band);
        $grabInfo->setEmail($grabInfoDto->email);
        $grabInfo->setDepth($grabInfoDto->depth);
        $grabInfo->setFinishedUrlsCounter(0);

        return $grabInfo;
    }
}
