<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AjoutFichierType;
use App\Form\ModifFichierType;
use App\Entity\Fichier;
use App\Controller\FichierController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

class FichierController extends AbstractController
{
    /**
     * @Route("/ajout_fichier", name="ajout_fichier")
     */
    public function ajoutFichier(Request $request)
    {
        $fichier = new Fichier();
        $form = $this->createForm(AjoutFichierType::class,$fichier);

        if ($request->isMethod('POST')){            
            $form -> handleRequest ($request);            
            if($form->isSubmitted() && $form->isValid()){              
                $em = $this->getDoctrine()->getManager();
                $file = $fichier->getNom();
                $fichier->setDate(new \DateTime()); //récupère la date du jour
                $fichier->setExtension($file->guessExtension()); // Récupère l’extension du fichier
                $fichier->setTaille($file->getSize()); // getSize contient la taille du fichier envoyé  
                $fichier->setVraiNom($file->getClientOriginalName());            
                
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                $fichier->setNom($fileName);
                $em->persist($fichier);              
                $em->flush();
                try{    
                    $file->move($this->getParameter('file_directory'),$fileName); // Nous déplaçons lefichier dans le répertoire configuré dans services.yaml
                    $this->addFlash('notice', 'Fichier inséré');

                } catch (FileException $e) {// erreur durant l’upload            
                    $this->addFlash('notice', 'Problème fichier inséré');
                }           
            } 
            return $this->redirectToRoute('ajout_fichier');
        }

        return $this->render('fichier/ajout_fichier.html.twig', [
           'form'=>$form->createView()
        ]);
    }
    /**     
     * * @return string     
     * 
     * */    
    private function generateUniqueFileName()    
    {        
        return md5(uniqid());    
    }

     /**
     * @Route("/liste_fichier", name="liste_fichier")
     */
    public function listeFichier(Request $request)
    {

        $em = $this->getDoctrine();
        $repoFichier = $em->getRepository(Fichier::class);

        if ($request->get('supp')!=null){
            $fichier = $repoFichier->find($request->get('supp'));
            if($fichier!=null){
                $em->getManager()->remove($fichier);
                $em->getManager()->flush();
            }    
            return $this->redirectToRoute('liste_fichier');
        }

        $fichiers = $repoFichier->findBy(array(), array('vraiNom'=>'ASC'));

        return $this->render('fichier/liste_fichier.html.twig', [
            'fichiers'=>$fichiers      
            
            ]);
    }

     /**
     * @Route("/telechargement_fichier/{id}", name="telechargement_fichier", requirements={"id"="\d+"})
     */
    public function telechargementFichier(int $id)
    {
      $em = $this->getDoctrine();
      $repoFichier = $em->getRepository(Fichier::class);  
      $fichier = $repoFichier->find($id);
      if ($fichier == null){
        $this->redirectToRoute('liste_fichier');
      }
      else{
        return $this->file($this->getParameter('file_directory').'/'.$fichier->getNom(),($fichier->getVraiNom()));  
        
      
      }
    }

      /**
     * @Route("/modif_fichier/{id}", name="modif_fichier", requirements={"id"="\d+"})
     */
    public function modifFichier(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoFichier = $em->getRepository(Fichier::class);
        $fichier = $repoFichier->find($id);

        if($fichier == null){
            $this->addFlash('notice', "Ce fichier n'existe pas");
            return $this->redirectToRoute('liste_fichier');
        }

        $form = $this->createForm(ModifFichierType::class,$fichier);

        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($fichier);
                $em->flush();    

                $this->addFlash('notice', 'Fichier modifié');

            }
            return $this->redirectToRoute('liste_fichier');
        }        

        return $this->render('fichier/modif_fichier.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
?>