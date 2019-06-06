<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class GrabInfoDto
{
    public $id;

    /**
     * @Assert\Length(max="255")
     */
    public $username;

    /**
     * @Assert\Email
     * @Assert\Length(max="255")
     */
    public $email;

    /**
     * @Assert\Length(max="255")
     */
    public $band;

    /**
     * @Assert\NotBlank
     * @Assert\Range(min="0", max="100000")
     */
    public $depth;

    /**
     * @var SiteDto[]
     */
    public $sites;

    public $finishedUrlsCounter;
}
