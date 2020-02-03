<?php

namespace App\Controller;

use App\Repository\BandRepository;
use App\Repository\FolderRepository;
use App\Repository\MusicianRepository;
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
     * @param MusicianRepository $musicianRepository
     * @param UserInterface|null $user
     * @return Response
     */
    public function index(FolderRepository $folderRepository, MusicianRepository $musicianRepository, ?UserInterface $user) :Response
    {
        if (isset($user)) {
            $musician = $musicianRepository->find($user->getId());
            $bands = $musician->getBands();
            $default = $musician->getDefaultBand();
            $active = $musician->getActiveBand();
            if ($default != $active && $active == null) {
                $folders = $folderRepository->findByBand($default);
                $entityManager = $this->getDoctrine()->getManager();
                $musician->setActiveBand($default);
                $entityManager->persist($musician);
                $entityManager->flush();
            } else {
                $folders = $folderRepository->findByBand($active);
            }

        } else {
            $folders = [];
            $bands = [];
        }

        if (isset($musician)) {
            $currentBand = $musician->getActiveBand();
        }else {
            $currentBand = [];
        };

        return $this->render('home/index.html.twig', [
            'currentId' => null,
            'folders' => $folders,
            'bands' => $bands,
            'currentBand' => $currentBand,
        ]);
    }

    /**
     * @Route("/change/{id}", name="change_band")
     * @param $id
     * @param MusicianRepository $musicianRepository
     * @param UserInterface|null $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeActiveBand ($id, MusicianRepository $musicianRepository, ?UserInterface $user)
    {
        $musician = $musicianRepository->find($user->getId());
        $entityManager = $this->getDoctrine()->getManager();
        $musician->setActiveBand($id);
        $entityManager->persist($musician);
        $entityManager->flush();
        return $this->redirectToRoute('home');
    }
}
