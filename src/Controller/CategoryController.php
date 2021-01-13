<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryController extends AbstractController
{

//    ---------------------------------------------- CREATE CATEGORY ---------------------------------------------    //

    /**
     * Display the category creation page.
     * @Route("admin/category/create", name="category_create")
     */
    public function create(Request $request, SluggerInterface $slugger, EntityManagerInterface $em)
    {
        $category = new Category();

        // Form creation on the CategoryType configuration
        $form = $this->createForm(CategoryType::class, $category);

        // The form checks if there is any information in the request
        $form->handleRequest($request);

        // If the form has been submitted
        if ($form->isSubmitted())
        {
            // Set up the Slug
            $category->setSlug(strtolower($slugger->slug($category->getname())));

            // We persist() and flush() with the help of the Manager
            $em->persist($category);
            $em->flush();

            // Redirect to the category
            return $this->redirectToRoute('product_category', [
                'slug' => $category->getSlug(),
            ]);
        }

        // Extract the class display part to communicate it to Twig
        $formView = $form->createView();

        // Return a Response with render()
        return $this->render('category/create.html.twig', [
            'formView' => $formView
        ]);
    }

//    ----------------------------------------------- EDIT CATEGORY ----------------------------------------------    //

    /**
     * Display the category creation page.
     * @Route("admin/category/{id}/edit", name="category_edit")
     */
    public function edit($id, CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $em)
    {
        // Select a category by Id
        $category = $categoryRepository->find($id);

        // Form creation on the CategoryType configuration, and filled in the fields automatically
        $form = $this->createForm(CategoryType::class, $category);

        // Extract the class display part to communicate it to Twig
        $formView = $form->createView();

        // The form checks if there is any information in the request
        $form->handleRequest($request);

        // If the form has been submitted
        if ($form->isSubmitted())
        {
            // We flush() with the help of the Manager
            $em->flush();

            // Redirect to the category
            return $this->redirectToRoute('product_category', [
                'slug' => $category->getSlug(),
            ]);
        }

        // Return a Response with render()
        return $this->render('category/edit.html.twig' ,[
            'category' => $category,
            'formView' => $formView
        ]);
    }
}
