<?php

namespace App\Model\File\Entity\Download;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class DownloadRepository
{
    private EntityManagerInterface $em;
    private ObjectRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(Download::class);
    }

    public function get(string $id): Download
    {
        /** @var Download $download */
        if (!$download = $this->repo->find($id)) {
            throw new EntityNotFoundException('Download is not found.');
        }
        return $download;
    }

    public function add(Download $download): void
    {
        $this->em->persist($download);
    }
}