<?php

namespace App\Controller\Api\File;

use App\Model\File\Entity\File\FileRepository;
use App\Model\File\UseCase\Download\Command;
use App\Model\File\UseCase\Download\Handler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/download", name="download")
 *
 * Class ContentController
 * @package App\Controller\Api\Download
 */
class DownloadController extends AbstractController
{
    private FileRepository $files;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(FileRepository $files, ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->files = $files;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/{id}", name=".file", methods={"GET"})
     * @param $id
     * @param Request $request
     * @param Handler $handler
     * @return Response
     */
    public function downloadFile($id, Request $request, Handler $handler): Response
    {
        $command = new Command($id, $request->getClientIp());

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');
            return new JsonResponse($json, 400, [], true);
        }

        $fileContent = $handler->handle($command);
        $file = $this->files->get($id);

        return $this->generateResponse($fileContent, $file->getInfo()->getName());

    }

    private function generateResponse($content, $fileName)
    {
        $response = new Response($content);

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            $fileName
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}