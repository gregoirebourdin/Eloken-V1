<?php


namespace App\Controller\Purchase;


use App\Entity\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class PurchaseConfirmationController extends AbstractController
{
//    --------------------------------------------- CART CONFIRM -------------------------------------------------    //

    /**
     * Confirm the cart for create an order.
     * @Route("/purchase/confirm", name="purchase_confirm")
     */
    public function index() {


        return $this->render('purchase/index.html.twig', [
            'purchases' => 'vjhbkj'
        ]);
    }
}