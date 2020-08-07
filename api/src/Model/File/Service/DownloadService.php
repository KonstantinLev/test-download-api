<?php

namespace App\Model\File\Service;

class DownloadService
{
    private \Redis $store;
    private string $timeInterval;
    private string $maxRequests;

    public function __construct(\Redis $redis, string $timeInterval, string $maxRequests)
    {
        $this->store = $redis;
        $this->timeInterval = $timeInterval;
        $this->maxRequests = $maxRequests;
    }

    public function isCanDownload(string $ip): bool
    {
        $key = $this->store->get($ip);
        return !$key || $key < $this->maxRequests;
    }

    public function recordDownload(string $ip)
    {
        if (!$this->store->get($ip)) {
            $this->store->set($ip, 0, ['nx', 'ex' => $this->timeInterval]);
        }
        $this->store->incr($ip);
    }

    public function getRemainingBlockingTime(string $ip): int
    {
        return $this->store->ttl($ip);
    }

}