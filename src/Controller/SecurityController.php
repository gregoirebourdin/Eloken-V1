<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
//    ------------------------------------------------- LOGIN ----------------------------------------------------    //

    /**
     * Display the login page.
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        // Form creation on the ProductType configuration
        $form= $this->createForm(LoginType::class, ['email' => $utils->getLastUsername()]);

        return $this->render('security/login.html.twig', [
            // Extract the class display part to communicate it to Twig
            'formView' => $form->createView(),
            'error' => $utils->getLastAuthenticationError()
        ]);
    }

//    ------------------------------------------------- LOGOUT ---------------------------------------------------    //

    /**
     * Used to disconnect a user.
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
    }
}
