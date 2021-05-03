<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Form\AjoutUtilisateurType;
use App\Form\ImageProfilType;
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

        $utilisateur->setDatenaissance(new \DateTime());
        $utilisateur->setDateinscription(new \DateTime());
        $form = $this->createForm(AjoutUtilisateurType::class, $utilisateur);

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

        /**
     * @Route("/liste_utilisateur", name="liste_utilisateur")
     */
    public function listeUtilisateur(Request $request)    {        
   
        $em = $this->getDoctrine();
        $repoUtilisateur = $em->getRepository(Utilisateur::class);
        $utilisateurs = $repoUtilisateur->findBy(array(), array('id'=>'ASC'));


        return $this->render('utilisateur/liste_utilisateurs.html.twig', [
            'utilisateurs'=>$utilisateurs      
            
            ]);


}

     /**
     * @Route("/userProfile/{id}", name="userProfile", requirements={"id"="\d+"})
     */
    public function userprofile(int $id, Request $request)
    {
     
        $em = $this->getDoctrine();
        $repoUtilisateur = $em->getRepository(Utilisateur::class);
        $utilisateur = $repoUtilisateur->find($id);
        if ($utilisateur==null){
            $this->addFlash('notice','Utilisateur introuvable');
            return $this->redirectToRoute('accueil');
        }
        $form = $this->createForm(ImageProfilType::class);
        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $form->get('photo')->getData();
                try{    
                    $fileName = $utilisateur->getId().'.'.$file->guessExtension();
                    $file->move($this->getParameter('profile_directory'),$fileName); // Nous déplaçons lefichier dans le répertoire configuré dans services.yaml
                    $em = $em->getManager();
                    $utilisateur->setPhoto($fileName);
                    $em->persist($utilisateur);
                    $em->flush();
                    $this->addFlash('notice', 'Fichier inséré');

                } catch (FileException $e) {                // erreur durant l’upload            }
                    $this->addFlash('notice', 'Problème fichier inséré');
                }
            }
        }    

        /*if($utilisateur->getPhoto()==null){
            $path = $this->getParameter('profile_directory').'/default.png';
        }
        else{
            $path = $this->getParameter('profile_directory').'/'.$utilisateur->getPhoto();
        }    
        $data = file_get_contents($path);
        $base64 = 'data:image/png;base64,' . base64_encode($data);
*/
        return $this->render('utilisateur/userProfile.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
           // 'base64' => $base64
        ]);
    }    


    
}
