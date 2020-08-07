<?php

namespace App\Model\File\Entity\File;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class FileRepository
{
    private EntityManagerInterface $em;
    private ObjectRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(File::class);
    }

    public function get(string $id): File
    {
        /** @var File $file */
        if (!$file = $this->repo->find($id)) {
            throw new EntityNotFoundException('File is not found.', 404);
        }
        return $file;
    }

}