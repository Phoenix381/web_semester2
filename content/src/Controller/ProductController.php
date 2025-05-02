<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'product_show')]
    public function show(Product $product, ProductRepository $productRepository): Response
    {
        // The Product $product parameter will be automatically fetched by Doctrine
        // thanks to Symfony's ParamConverter when the {id} is provided in the URL
        
        // If you need more control, you can fetch it manually:
        // $product = $productRepository->find($id);
        
        // Or handle not found case:
        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
