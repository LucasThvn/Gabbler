<?php

namespace App\Controller;

use App\Repository\FolderRepository;
use App\Repository\TrackRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param FolderRepository $folderRepository
     * @param UserInterface|null $user
     * @return Response
     */
    public function index(FolderRepository $folderRepository, ?UserInterface $user) :Response
    {
        if (isset($user)) {

            $folders = $folderRepository->findByMusician($user->getId());
        } else {
            $folders = [];
        }

        return $this->render('home/index.html.twig', [
            'folders' => $folders,
        ]);
    }
}
