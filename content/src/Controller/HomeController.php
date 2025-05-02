<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(LoggerInterface $logger, EntityManagerInterface $entityManager): Response
    {
        return $this->render('main/home.html.twig', [
            'test' => 'test',
        ]);
    }
}
