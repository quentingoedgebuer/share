<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Form\AjoutUtilisateurType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class UtilisateurController extends AbstractController
{
    /**
     * @Route("/ajout_utilisateur", name="ajout_utilisateur")
     */
    public function ajoutUtilisateur(Request $request)
    {

        $utilisateur = new Utilisateur(); 

        $form = $this->createFormBuilder($utilisateur)   
        ->add('nom', TextType::class)
        ->add('prenom', TextType::class)
        ->add('datenaissance', DateType::class)
        ->add('save', SubmitType::class, array('label' => 'Ajouter'))            
        ->getForm();

        if ($request->isMethod('POST')){            
            $form -> handleRequest ($request);            
            if($form->isValid()){              
                $em = $this->getDoctrine()->getManager();              
                $em->persist($utilisateur);              
                $em->flush();            
            } 
            return $this->redirectToRoute('ajout_utilisateur');
        }

        return $this->render('utilisateur/ajout_utilisateur.html.twig', [
            'form'=>$form->createView(), 
           
        ]);
    }
}
