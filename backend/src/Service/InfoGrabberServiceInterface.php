<?php

namespace App\Service;

use App\Entity\GrabInfo;

interface InfoGrabberServiceInterface
{
    public function grab(GrabInfo $grabInfo, \DOMDocument $dom, string $url): int;
}
