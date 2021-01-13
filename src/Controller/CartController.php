<?php

namespace App\Controller;

use App\Cart\CartService;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    protected $productRepository;
    protected $cartService;

    public function __construct(ProductRepository $productRepository, CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->productRepository = $productRepository;
    }


//    ----------------------------------------------- CART ADD ---------------------------------------------------    //

    /**
     * Add a product to the cart.
     * @Route("/cart/add/{id}", name="cart_add", requirements={"id":"\d+"})
     */
    public function add($id)
    {

        $product = $this->productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException("Le produit $id n'existe pas");
        }

        $this->cartService->add($id);

        $this->addFlash("info", "Vous pouvez désormais aller le voir dans votre panier.");

        return $this->redirectToRoute('product_show', [
            'category_slug' => $product->getCategory()->getSlug(),
            'slug' => $product->getSlug()
        ]);
    }

//    ---------------------------------------------- CART SHOW ---------------------------------------------------    //

    /**
     * Display the cart page.
     * @Route("/cart", name="cart_show")
     */
    public function show()
    {
        $detailedCart = $this->cartService->getDetailedCartItems();

        $total = $this->cartService->getTotal();

        return $this->render('cart/index.html.twig', [
            'items' => $detailedCart,
            'total' => $total
        ]);
    }

//    --------------------------------------------- CART DELETE --------------------------------------------------    //

    /**
     * Delete a cart element.
     * @Route("/cart/delete/{id}", name="cart_delete", requirements={"id" : "\d+"})
     */
    public function delete($id)
    {
        $product = $this->productRepository->find($id);

        if(!$product) {
            throw $this->createNotFoundException("Le produit $id n'existe pas et ne peut pas etre supprimé");
        }

        $this->cartService->remove($id);

        $this->addFlash("success", "Le produit a bien été supprimé du panier");

        return $this->redirectToRoute("cart_show");
    }
}
