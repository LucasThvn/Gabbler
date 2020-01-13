<?php

namespace App\Controller;

use App\Repository\FolderRepository;
use App\Repository\TrackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OpenFolderController extends AbstractController
{
    /**
     * @param $id
     * @param FolderRepository $folderRepository
     * @return Response
     * @route("open/{id}", name="open")
     */
    public function open ($id, FolderRepository $folderRepository)
    {
        $folder = $folderRepository->find($id);
        $tracks = $folder->getTracks();
        $active = '';

        return $this->render('open_folder/index.html.twig', [
            'folders' => $folderRepository->findAll(),
            'currentFolder' => $folder,
            'tracks' => $tracks,
            'active' => $active,
        ]);
    }
}
