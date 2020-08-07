<?php

namespace App\Controller\Api\File;

use App\ReadModel\File\DownloadFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/stat", name="stat")
 *
 * Class StatController
 * @package App\Controller\Api\File
 */
class StatController extends AbstractController
{
    /**
     * @Route("/{id}", name=".file", methods={"GET"})
     * @param $id
     * @param DownloadFetcher $fetcher
     * @return Response
     */
    public function stat($id, DownloadFetcher $fetcher): Response
    {;
        return $this->json([
            'file_id' => $id,
            'downloads' => array_map(static function (?array $item) {
                return [
                    'ip' => $item['ip'],
                    'count' => $item['downloads'],
                ];
            }, $fetcher->findStatByIdFile($id)),
        ]);
    }
}