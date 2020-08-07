<?php

namespace App\Service;

use League\Flysystem\FilesystemInterface;

class Storage
{
    private FilesystemInterface $storage;
    private string $basUrl;

    public function __construct(FilesystemInterface $storage, string $basUrl)
    {
        $this->storage = $storage;
        $this->basUrl = $basUrl;
    }

    /**
     * @param string $path
     * @return false|string
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function read(string $path)
    {
        return $this->storage->read($path);
    }

    public function has(string $path)
    {
        return $this->storage->has($path);
    }
}