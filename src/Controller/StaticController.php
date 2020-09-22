<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;

class StaticController extends AbstractController
{
    /**
     * @Route("/static", name="static")
     */
    public function index()
    {
        return $this->render('static/index.html.twig', [
            'controller_name' => 'StaticController',
        ]);
    }

    /**
     * @Route("/accueil", name="accueil")
     */
    public function accueil()
    {
        return $this->render('static/accueil.html.twig', [
            'controller_name' => 'StaticController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);

        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $this->addFlash('notice','Bouton appuyé');

                // Envoyer un email                
                $message = (new \Swift_Message($form->get('subject')->getData()))                        
                ->setFrom($form->get('email')->getData())                        
                ->setTo('qgoedgebue19@lmarras.org')                        
                ->setBody($form->get('message')->getData());   

                $mailer->send($message);
            }
        }
        return $this->render('static/contact.html.twig', [
            'form'=>$form->createView()
            
        ]);
    }

    
}
