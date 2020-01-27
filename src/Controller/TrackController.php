<?php

namespace App\Controller;

use App\Entity\Track;
use App\Form\TrackType;
use App\Repository\FolderRepository;
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
     * @Route("/", name="track_index", methods={"GET"})
     * @param TrackRepository $trackRepository
     * @return Response
     */
    public function index(TrackRepository $trackRepository): Response
    {
        return $this->render('track/index.html.twig', [
            'tracks' => $trackRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="track_new", methods={"GET","POST"})
     * @param $id
     * @param Request $request
     * @param FolderRepository $folderRepository
     * @return Response
     */
    public function new($id, Request $request, FolderRepository $folderRepository, ?UserInterface $user): Response
    {
        $folder = $folderRepository->find($id);
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
            'folders' => $folderRepository->findByMusician($user->getId()),
            'currentFolder' => $folder,
            'id' => $id,
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
     * @Route("/{id}", name="track_delete", methods={"DELETE"})
     * @param Request $request
     * @param Track $track
     * @return Response
     */
    public function delete(Request $request, Track $track): Response
    {
        if ($this->isCsrfTokenValid('delete'.$track->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($track);
            $entityManager->flush();
        }

        return $this->redirectToRoute('track_index');
    }
}
