<?php

namespace App\Controller;

use App\Entity\Track;
use App\Form\TrackType;
use App\Repository\FolderRepository;
use App\Repository\MusicianRepository;
use App\Repository\TrackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/track")
 */
class TrackController extends AbstractController
{
    /**
     * @Route("/new/{id}", name="track_new", methods={"GET","POST"})
     * @param $id
     * @param Request $request
     * @param FolderRepository $folderRepository
     * @return Response
     */
    public function new($id, Request $request, FolderRepository $folderRepository, ?UserInterface $user, MusicianRepository $musicianRepository): Response
    {
        $musician = $musicianRepository->find($user->getId());
        $bands = $musician->getBands();
        $folder = $folderRepository->findById($id, $musician->getActiveBand());
        $track = new Track();
        $form = $this->createForm(TrackType::class, $track);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $track->setFolder($folder);
            $track->setOwner($user->getUsername());
            $entityManager->persist($track);
            $entityManager->flush();
            return $this->redirectToRoute('open', ['id' => $id]);
        }

        return $this->render('track/new.html.twig', [
            'track' => $track,
            'form' => $form->createView(),
            'currentFolder' => $folder,
            'id' => $id,
            'bands' => $bands,
            'currentBand' => $musician->getActiveBand(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="track_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Track $track
     * @return Response
     */
    public function edit(Request $request, Track $track): Response
    {
        $form = $this->createForm(TrackType::class, $track);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('track_index');
        }

        return $this->render('track/edit.html.twig', [
            'track' => $track,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/{folderId}", name="track_delete", methods={"DELETE"})
     * @param Request $request
     * @param Track $track
     * @return Response
     */
    public function delete(Request $request, Track $track, $folderId): Response
    {
        if ($this->isCsrfTokenValid('delete'.$track->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($track);
            $entityManager->flush();
        }

        return $this->redirectToRoute('open', ['id' => $folderId]);
    }
}
