<?php

namespace App\Controller;

use App\Repository\FolderRepository;
use App\Repository\TrackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OpenFolderController extends AbstractController
{
    /**
     * @param $id
     * @route("open/{id}", name="open")
     */
    public function open ($id, FolderRepository $folderRepository, TrackRepository $trackRepository)
    {
        $folder = $folderRepository->find($id);
        $tracks = $folder->getTracks();

        return $this->render('open_folder/index.html.twig', [
            'folders' => $folderRepository->findAll(),
            'folder' => $folder,
            'tracks' => $tracks,
        ]);
    }
}
