<?php

namespace App\Dto;

class GrabResultDto
{
    public $id;

    public $context;

    public $url;

    /**
     * @var GrabInfoDto
     */
    public $grabInfo;
}
