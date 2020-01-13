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
     * @param FolderRepository $folderRepository
     * @return Response
     */
    public function index(FolderRepository $folderRepository) :Response
    {
        return $this->render('home/index.html.twig', [
            'folders' => $folderRepository->findAll(),
        ]);
    }
}
