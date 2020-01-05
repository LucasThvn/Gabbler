<?php

namespace App\Controller;

use App\Repository\FolderRepository;
use App\Repository\TrackRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(FolderRepository $folderRepository) :Response
    {
        return $this->render('home/index.html.twig', [
            'folders' => $folderRepository->findAll(),
        ]);
    }

    /**
     * @param $id
     * @route("/{id}", name="open")
     */
    public function open ($id, FolderRepository $folderRepository, TrackRepository $trackRepository)
    {
        $folder = $folderRepository->find($id);
        $tracks = $folder->getTracks();

        return $this->render('home/index.html.twig', [
            'folders' => $folderRepository->findAll(),
            'folder' => $folder,
            'tracks' => $tracks,
        ]);
    }
}
