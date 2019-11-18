<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Visiteur;
use App\Form\LoginVisiteurType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Psr\Log\LoggerInterface; //injection du service

class VisiteurController extends AbstractController
{
    /**
     * @Route("/visiteur", name="visiteur")
     */
    public function index()
    {
        return $this->render('visiteur/index.html.twig', [
            'controller_name' => 'visiteur',
       ]);
    }
    
    /**
     * @Route("/LoginVisiteur", name="LoginVisiteur")
     */ 
    
    public function LoginVisiteur(Request $query){
        $visit = new Visiteur();
        $submit = false;
        $form = $this->createForm(LoginVisiteurType::class, $visit);
        $form->handleRequest($query);
        //$request = Request::createFromGlobals();
      // On fait le lien Requête <-> Formulaire
      // À partir de maintenant, la variable $visiteur contient les valeurs entrées dans le formulaire par le candidat
        if ($form->isSubmitted() && $form->isValid()) {
                 
            $login = $form['login']->getData();
            $mdp = $form['mdp']->getData();
            $lesVisiteurs = $this->getDoctrine()->getRepository(Visiteur::class)->findall();
            
            
            foreach($lesVisiteurs as $visiteur){
                if($visiteur->getLogin()==$login && $visiteur->getMdp() == $mdp ){
                    $session = new session();
                    $session->set('nom',$visiteur->getNom());
                    $session->set('prenom',$visiteur->getPrenom());
                    $_SESSION['login'] = true ; 
                    return $this -> redirect('AccueilVisiteur');
                }
                $submit = true;
            }    
        }
        return $this->render('visiteur/LoginVisiteur.html.twig',array('form'=>$form->createView(),'connexion'=>$submit,));
        }
    
    /**
     * @Route("/AccueilVisiteur", name="AccueilVisiteur")
     */
    public function AccueilVisiteur()
    {
        if(isset($_SESSION['login'])){
            if($_SESSION['login'] == true){
                return $this->render('visiteur/AcceuilVisiteur.html.twig');
            }
        }
        return $this -> redirect('LoginVisiteur');
    }
    
    
    /**
     * @Route("/SaisirFicheFrais", name="SaisirFicheFrais")
     */
    public function SaisirFicheFrais(){
        
        $lesVisiteurs = $this->getDoctrine()->getRepository(Visiteur::class)->findall();
      
        return $this->render('visiteur/VueFicheFraisVisiteur.html.twig', [
            'controller_name' => 'SaisirFicheFrais', 'visiteurs' => $lesVisiteurs ,
       ]);
    }
    
    /**
     * @Route("/ConsultationFicheFrais", name="ConsultationFicheFrais")
     */
    public function ConsultationFicheFrais(){
        
        $lesVisiteurs = $this->getDoctrine()->getRepository(Visiteur::class)->findall();
      
        return $this->render('visiteur/VueConsultationFrais.html.twig', [
            'controller_name' => 'ConsultationFicheFrais', 'visiteurs' => $lesVisiteurs ,
       ]);
    }
    
     /**
     * @Route("/DeconnexionVisiteur", name="DeconnexionVisiteur")
     */
    public function DeconnexionVisiteur(){
        if(isset($_SESSION['login'])){
            if($_SESSION['login'] == true){
                $_SESSION['login'] = false;
                return $this -> redirect('LoginVisiteur');
            }
}
    }
    
    /**
     * @Route("/logger")
     */
    
    public function list(LoggerInterface $logger)
    {
        $logger->info('verifier votre log') ;
        return $this->render("visiteur/index.html.twig") ;
    }
}
