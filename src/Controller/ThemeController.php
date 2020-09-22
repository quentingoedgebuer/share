<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Theme;
use App\Form\Ajout_themeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ThemeController extends AbstractController
{
    /**
     * @Route("/ajout_theme", name="ajout_theme")
     */


    
    public function ajout_theme(Request $request)
    {
        $theme = new Theme(); 

        $form = $this->createFormBuilder($theme)   
        ->add('libelle', TextType::class)
        ->add('save', SubmitType::class, array('label' => 'Ajouter'))            
        ->getForm();

        if ($request->isMethod('POST')){            
            $form -> handleRequest ($request);            
            if($form->isValid()){              
                $em = $this->getDoctrine()->getManager();              
                $em->persist($theme);              
                $em->flush();            
            } 
            return $this->redirectToRoute('ajout_theme');
        }

        return $this->render('theme/ajout_theme.html.twig', [
            'form'=>$form->createView(),       
            
            ]);
    }


     /**
     * @Route("/liste_theme", name="liste_theme")
     */
    public function listeThemes(Request $request)    {        
   
        $em = $this->getDoctrine();
        $repoTheme = $em->getRepository(Theme::class);
        $themes = $repoTheme->findBy(array(), array('libelle'=>'ASC'));


        return $this->render('theme/liste_theme.html.twig', [
            'themes'=>$themes      
            
            ]);


}
}