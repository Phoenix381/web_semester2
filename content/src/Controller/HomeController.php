<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Product;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(LoggerInterface $logger, EntityManagerInterface $entityManager): Response
    {
        // get products
        $products = $entityManager->getRepository(Product::class)->findAll();
        $logger->error($products[0]::class);

        return $this->render('main/home.html.twig', [
            'products' => $products,
        ]);
    }
}
