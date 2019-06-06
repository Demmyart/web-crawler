<?php

namespace App\Service;

use App\Dto\SiteDto;
use App\Entity\Site;

class SiteService
{
    public function convertToDto(Site $site): SiteDto
    {
        $siteDto = new SiteDto();
        $siteDto->id = $site->getId();
        $siteDto->url = $site->getUrl();
        $siteDto->restrictByUrl = $site->getRestrictByUrl();

        return $siteDto;
    }
}
