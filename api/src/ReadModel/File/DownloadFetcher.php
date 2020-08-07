<?php

namespace App\ReadModel\File;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class DownloadFetcher
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findStatByIdFile(string $id): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'ip',
                'count(ip) as downloads',
            )
            ->from('file_downloads')
            ->where('file_id = :id')
            ->groupBy('ip')
            ->orderBy('downloads', 'desc')
            ->setParameter(':id', $id)
            ->execute();
        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}