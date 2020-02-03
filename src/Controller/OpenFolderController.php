<?php

namespace App\Controller;

use App\Repository\BandRepository;
use App\Repository\FolderRepository;
use App\Repository\MusicianRepository;
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
    public function open ($id, FolderRepository $folderRepository, ?UserInterface $user, MusicianRepository $musicianRepository)
    {
        $musician = $musicianRepository->find($user->getId());
        $folder = $folderRepository->findById($id, $musician->getActiveBand());

        return $this->render('open_folder/index.html.twig', [
            'tracks' => $folder->getTracks(),
            'currentFolder' => $folder,
            'currentId' => $id,
            'folders' => $folderRepository->findByBand($musician->getActiveBand()),
            'bands' => $musician->getBands(),
            'currentBand' => $musician->getActiveBand(),
        ]);
    }
}
