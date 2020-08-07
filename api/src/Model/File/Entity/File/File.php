<?php

namespace App\Model\File\Entity\File;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="file_files", indexes={
 *     @ORM\Index(columns={"date"})
 * })
 */
class File
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
     * @var Info
     * @ORM\Embedded(class="Info")
     */
    private Info $info;

    public function __construct(\DateTimeImmutable $date, Info $info)
    {
        $this->date = $date;
        $this->info = $info;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getInfo(): Info
    {
        return $this->info;
    }

    public function getUrl(): string
    {
        return $this->info;
    }
}