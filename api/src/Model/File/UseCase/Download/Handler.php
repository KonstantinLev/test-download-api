<?php

namespace App\Model\File\UseCase\Download;

use App\Helper\TimeHelper;
use App\Model\File\Entity\Download\Download;
use App\Model\File\Entity\Download\DownloadRepository;
use App\Model\File\Entity\File\FileRepository;
use App\Model\File\Service\DownloadService;
use App\Model\Flusher;
use App\Service\Storage;

class Handler
{
    private FileRepository $files;
    private DownloadRepository $downloads;
    private DownloadService $downloadService;
    private Storage $storage;
    private Flusher $flusher;

    public function __construct(
        FileRepository $files,
        DownloadRepository $downloads,
        DownloadService $downloadService,
        Storage $storage,
        Flusher $flusher)
    {
        $this->files = $files;
        $this->downloads = $downloads;
        $this->downloadService = $downloadService;
        $this->storage = $storage;
        $this->flusher = $flusher;
    }

    public function handle(Command $command)
    {
        $file = $this->files->get($command->id);

        if (!$this->downloadService->isCanDownload($command->ip)) {
            $time = TimeHelper::format($this->downloadService->getRemainingBlockingTime($command->ip));
            throw new \DomainException('The file download is blocked. Try in ' . $time, 400);
        }

        $path = $file->getInfo()->getPath() . '/' . $file->getInfo()->getName();

        if (!$this->storage->has($path)) {
            throw new \DomainException('File not found on the server.', 404);
        }

        $download = Download::log($command->ip, $file, new \DateTimeImmutable());
        $this->downloads->add($download);
        $this->flusher->flush();

        $this->downloadService->recordDownload($command->ip);

        return $this->storage->read($path);
    }
}