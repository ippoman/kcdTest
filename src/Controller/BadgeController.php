<?php

namespace App\Controller;

use Carbon\carbon;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BadgeController extends AbstractController
{
    #[IsGranted("ROLE_USER")]
    #[Route('/badge/{id}', name: 'app_badge')]
    public function index(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {

        $date = new DateTimeImmutable();
        

        return $this->render('badge/index.html.twig', [
            'user' => $user,
            'date' => $date,

        ]);
    }
}
