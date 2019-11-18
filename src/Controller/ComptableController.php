<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comptable;
use App\Entity\Visiteur;
use App\Form\LoginComptableType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ComptableController extends AbstractController
{
    /**
     * @Route("/Comptable", name="Comptable")
     */
  
    public function index()
    {
        return $this->render('comptable/index.html.twig', [
            'controller_name' => 'Comptable',
       ]);
    }
    
    /**
     * @Route("/LoginComptable", name="LoginComptable")
     */
    public function LoginComptable(Request $query){
        $compt = new Comptable();
        $submit = false;
        $form = $this->createForm(LoginComptableType::class, $compt);
        $form->handleRequest($query);
        //$request = Request::createFromGlobals();
      // On fait le lien Requête <-> Formulaire
      // À partir de maintenant, la variable $visiteur contient les valeurs entrées dans le formulaire par le candidat
        if ($form->isSubmitted() && $form->isValid()) {
                 
            $login = $form['login']->getData();
            $mdp = $form['mdp']->getData();
            $lesComp = $this->getDoctrine()->getRepository(Comptable::class)->findall();
            
            
            foreach($lesComp as $comptable){
                if($comptable->getLogin()==$login && $comptable->getMdp() == $mdp ){
                    $session = new session();
                    $session->set('nom',$comptable->getNom());
                    $session->set('prenom',$comptable->getPrenom());
                    $_SESSION['login'] = true ; 
                    return $this -> redirect('AccueilComptable');
                }
                $submit = true;
            }    
        }
        return $this->render('Comptable/LoginComptable.html.twig',array('form'=>$form->createView(),'connexion'=>$submit,));
        }
    
    /**
     * @Route("/AccueilComptable", name="AccueilComptable")
     */
    public function AccueilComptable()
    {
        if(isset($_SESSION['login'])){
            if($_SESSION['login'] == true){
                return $this->render('Comptable/AccueilComptable.html.twig');
            }
        }
        return $this -> redirect('LoginComptable');
    }
    
    
    /**
     * @Route("/ValiderFicheFrais", name="ValiderFicheFrais")
     */
    public function ValiderFicheFrais(){
        
        $lesVisiteurs = $this->getDoctrine()->getRepository(Visiteur::class)->findall();
      
        return $this->render('Comptable/ValiderFicheFrais.html.twig', [
            'controller_name' => 'ValiderFicheFrais', 'visiteurs' => $lesVisiteurs ,
       ]);
            
        
    }
    
    /**
     * @Route("/SuivrePaiementFicheFrais", name="SuivrePaiementFicheFrais")
     */
    public function SuivrePaiementFicheFrais(){
        
        $lesVisiteurs = $this->getDoctrine()->getRepository(Visiteur::class)->findall();
      
        return $this->render('Comptable/VueSuivrePaiement.html.twig', [
            'controller_name' => 'SuivrePaiementFicheFrais', 'visiteurs' => $lesVisiteurs ,
       ]);
            
        
    }
    
     /**
     * @Route("/DeconnexionComptable", name="DeconnexionComptable")
     */
    public function DeconnexionComptable(){
        if(isset($_SESSION['login'])){
            if($_SESSION['login'] == true){
                $_SESSION['login'] = false;
                return $this -> redirect('LoginComptable');
            }
                
        }
        return $this -> redirect('LoginComptable');
            
        
    }
    

}
