<?php

namespace App\Controller;

use App\Repository\MusicianRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function profile(MusicianRepository $musicianRepository, UserInterface $user): Response
    {
        $musician = $musicianRepository->find($user->getId());


        return $this->render('profile/profile.html.twig', [
            'bands' => $musician->getBands(),
            'currentBand' => $musician->getActiveBand(),
        ]);
    }
}
