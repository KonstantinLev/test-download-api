<?php

namespace App\Model\File\Entity\Download;

use App\Model\File\Entity\File\File;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="file_downloads", indexes={
 *     @ORM\Index(columns={"date"})
 * })
 */
class Download
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $date;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $ip;

    /**
     * @var File
     * @ORM\ManyToOne(targetEntity="App\Model\File\Entity\File\File")
     * @ORM\JoinColumn(nullable=false)
     */
    private File $file;

    public function __construct(string $ip, File $file, \DateTimeImmutable $date)
    {
        $this->ip = $ip;
        $this->file = $file;
        $this->date = $date;
    }

    public static function log(string $ip, File $file, \DateTimeImmutable $date): self
    {
        return new self($ip, $file, $date);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }
}