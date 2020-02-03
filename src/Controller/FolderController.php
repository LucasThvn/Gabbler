<?php

namespace App\Controller;

use App\Entity\Folder;
use App\Entity\Musician;
use App\Form\FolderType;
use App\Repository\BandRepository;
use App\Repository\FolderRepository;
use App\Repository\MusicianRepository;
use Cassandra\Time;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/folder")
 */
class FolderController extends AbstractController
{
    /**
     * @Route("/new", name="folder_new", methods={"GET","POST"})
     * @param Request $request
     * @param UserInterface|null $user
     * @param MusicianRepository $musicianRepository
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request, ?UserInterface $user, MusicianRepository $musicianRepository, BandRepository $bandRepository): Response
    {
        $folder = new Folder();
        $dateTime = new DateTime();
        $form = $this->createForm(FolderType::class, $folder);
        $form->handleRequest($request);
        $musician = $musicianRepository->find($user->getId());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $folder->setDateCreated($dateTime);
            $folder->setBand($bandRepository->findOneBy(['id' => $musician->getActiveBand()]));
            $entityManager->persist($folder);
            $entityManager->flush();

            return $this->redirectToRoute('open', ['id' => $folder->getId()]);
        }

        return $this->render('folder/new.html.twig', [
            'folder' => $folder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="folder_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Folder $folder
     * @return Response
     */
    public function edit(Request $request, Folder $folder): Response
    {
        $form = $this->createForm(FolderType::class, $folder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('folder_index');
        }

        return $this->render('folder/edit.html.twig', [
            'folder' => $folder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="folder_delete", methods={"DELETE"})
     * @param Request $request
     * @param Folder $folder
     * @return Response
     */
    public function delete(Request $request, Folder $folder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$folder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($folder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('folder_index');
    }
}
