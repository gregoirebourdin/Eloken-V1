<?php

namespace App\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    protected function getCart() : array {
        return $this->session->get('cart', []);
    }

    protected function saveCart(array $cart) {
        $this->session->set('cart', $cart);
    }

    // Allows you to delete a product to the cart
    public function remove(int $id) {

        $cart = $this->getCart();

        unset($cart[$id]);

        $this->saveCart($cart);
    }

    // Allows you to add a product to the cart
    public function add(int $id) {

        $cart = $this->getCart();

        if (!array_key_exists($id, $cart)) {
            $cart[$id] = 0;
        }

        $cart[$id] = 1;

        $this->saveCart($cart);
    }

    // Allows to have the total of the cart
    public function getTotal() : int {
        $total = 0;

        foreach ($this->getCart() as $id => $qty) {
            $product = $this->productRepository->find($id);

            if (!$product) {
                continue;
            }

           $total += $product->getPrice() * $qty;
        }
        return $total;
    }

    // Allows you to retrieve items from a shopping cart
    public function getDetailedCartItems() : array {
        $detailedCart = [];

        foreach ($this->getCart() as $id => $qty) {
            $product = $this->productRepository->find($id);

            if (!$product) {
                continue;
            }

            $detailedCart[] = new CartItem($product, $qty);
        }
        return $detailedCart;
    }
}