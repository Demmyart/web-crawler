<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class SiteDto
{
    public $id;

    /**
     * @Assert\NotBlank
     * @Assert\Url
     * @Assert\Length(max="255")
     */
    public $url;

    /**
     * @Assert\NotBlank
     * @Assert\Url
     * @Assert\Length(max="255")
     */
    public $restrictByUrl;
}
