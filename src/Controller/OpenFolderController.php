<?php

namespace App\Controller;

use App\Repository\FolderRepository;
use App\Repository\TrackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class OpenFolderController extends AbstractController
{
    /**
     * @param $id
     * @param FolderRepository $folderRepository
     * @param UserInterface|null $user
     * @return Response
     * @route("open/{id}", name="open")
     */
    public function open ($id, FolderRepository $folderRepository, ?UserInterface $user)
    {
        $folders = $folderRepository->findById($id, $user->getId());
        foreach ($folders as $folder) {
            $tracks = $folder->getTracks();
        }

        $active = '';

        return $this->render('open_folder/index.html.twig', [
            'folders' => $folderRepository->findByMusician($user->getId()),
            'tracks' => $tracks,
            'currentFolder' => $folder,
            'active' => $active,
        ]);
    }
}
