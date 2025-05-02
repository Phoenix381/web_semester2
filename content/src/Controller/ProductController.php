<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Review;
use App\Form\ReviewTypeForm;

class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'product_show')]
    public function show(Product $product, Request $request, ProductRepository $productRepository, EntityManagerInterface $em): Response
    {
        $review = new Review();
        $form = $this->createForm(ReviewTypeForm::class, $review);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $review->setProduct($product);
            // $review->setCreatedAt(new \DateTimeImmutable());
            
            // If you have user authentication
            if ($this->getUser()) {
                $review->setOwner($this->getUser());
            }
            
            $em->persist($review);
            $em->flush();

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'review_form' => $form->createView(),
        ]);
    }
}
