<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

//    ---------------------------------------------- ALL PRODUCT -------------------------------------------------    //

    /**
     * Display the listing of products by category.
     * @Route("/{slug}", name="product_category", priority="-1")
     */
    public function category($slug, CategoryRepository $categoryRepository)
    {
        // Select a category by Slug
        $category = $categoryRepository->findOneBy([
            'slug' => $slug
        ]);

        // Return the products
        return $this->render('product/category.html.twig', [
            'slug' => $slug,
            'category' => $category
        ]);
    }

//    ---------------------------------------------- DETAILS PRODUCT ---------------------------------------------    //

    /**
     * Display the Product details page.
     * @Route("/{category_slug}/{slug}", name="product_show")
     */
    public function show($slug, ProductRepository $productRepository)
    {
        // Select a product by Slug
        $product = $productRepository->findOneBy([
            'slug' => $slug
        ]);

        // Return the product
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }

//    ---------------------------------------------- EDIT PRODUCT ------------------------------------------------    //

    /**
     * Display the product edit page.
     * @Route("/admin/product/{id}/edit", name="product_edit")
     */
    public function edit($id, ProductRepository $productRepository, Request $request, EntityManagerInterface $em)
    {
        // Select a product by Id
        $product = $productRepository->find($id);

        // Form creation on the ProductType configuration, and filled in the fields automatically
        $form = $this->createForm(ProductType::class, $product);

        // Extract the class display part to communicate it to Twig
        $formView = $form->createView();

        // The form checks if there is any information in the request
        $form->handleRequest($request);

        // If the form has been submitted
        if ($form->isSubmitted() && $form->isValid())
        {
            // We flush() with the help of the Manager
            $em->flush();

            // Redirect to the product
            return $this->redirectToRoute('product_show', [
                'category_slug' => $product->getCategory()->getSlug(),
                'slug' => $product->getSlug()
            ]);

        }

        // Return a Response with render()
        return $this->render('product/edit.html.twig' ,[
            'product' => $product,
            'formView' => $formView
        ]);
    }

//    ---------------------------------------------- CREATE PRODUCT ----------------------------------------------    //

    /**
     * Display the product creation page.
     * @Route("/admin/product/create", name="product_create")
     */
    public function create(Request $request, SluggerInterface $slugger, EntityManagerInterface $em)
    {
        $product = new Product;

        // Form creation on the ProductType configuration
        $form = $this->createForm(ProductType::class, $product);

        // The form checks if there is any information in the request
        $form->handleRequest($request);

        // If the form has been submitted
        if ($form->isSubmitted())
        {
            // Set up the Slug
            $product->setSlug(strtolower($slugger->slug($product->getname())));

            // We persist() and flush() with the help of the Manager
            $em->persist($product);
            $em->flush();

            // Redirect to the product
            return $this->redirectToRoute('product_show', [
                'category_slug' => $product->getCategory()->getSlug(),
                'slug' => $product->getSlug()
            ]);
        }

        // Extract the class display part to communicate it to Twig
        $formView = $form->createView();

        // Return a Response with render()
        return $this->render('product/create.html.twig', [
            'formView' => $formView
        ]);
    }
}
