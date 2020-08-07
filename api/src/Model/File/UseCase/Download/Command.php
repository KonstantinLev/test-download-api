<?php

namespace App\Model\File\UseCase\Download;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Type(type="digit")
     */
    public string $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $ip;

    public function __construct(string $id, string $ip)
    {
        $this->id = $id;
        $this->ip = $ip;
    }
}