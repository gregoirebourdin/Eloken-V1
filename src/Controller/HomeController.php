<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

//    ------------------------------------------------ HOMEPAGE --------------------------------------------------    //

    /**
     * Display the home page.
     * @Route("/", name="homepage")
     */
    public function homepage(ProductRepository $productRepository)
    {
        // Select the products by 4
        $products = $productRepository->findBy([], [], 4);

        // Return the products
        return $this->render('home/home.html.twig', [
            'products' => $products
        ]);
    }
}
