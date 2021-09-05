<?php  
// src/Controller/HomeController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sport;
use App\Entity\Membre;
use App\Form\AddMembreType;
use App\Form\AddSportType;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home(){
        //Function
        return $this->render('asint/home.html.twig',[]);
    }
    
    /**
     * @Route("/sports", name="sports")
     */
    public function sports(){
        
        return $this->render('asint/sports.html.twig',[]);
    }
    
    /**
     * @Route("/evenements", name="evenements")
     */
    public function evenements(){
        
        return $this->render('asint/evenements.html.twig',[]);
    }
    
    /**
     * @Route("/partenaires", name="partenaires")
     */
    public function partenaires(){
        
        return $this->render('asint/partenaires.html.twig',[]);
    }
    
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(){
        
        return $this->render('asint/contact.html.twig',[]);
    }
    
    /**
     * @Route("/667equipe", name="equipe")
     */
    public function equipe(){
        
        return $this->render('asint/equipe.html.twig',[]);
    }
    
    /**
     * @Route("/addsport", name="addSport")
     */
    public function addSport(Request $request){
        $sport = new Sport();
        
        $form = $this->createForm(AddSportType::class, $sport);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $sport = $form->getData();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($sport);
            $em->flush();
            
            return $this->redirectToRoute('home');
        }
        return $this->render('asint/addSport.html.twig',['form' => $form->createView(),]);
    }
    
    /**
     * @Route("/addmembre", name="addMembre")
     */
    public function addMembre(Request $request){
        $membre = new Membre();
        
        $form = $this->createForm(AddMembreType::class, $membre);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $membre = $form->getData();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();
            
            return $this->redirectToRoute('home');
        }
        
        return $this->render('asint/addMembre.html.twig',['form' => $form->createView(),]);
    }
}

?>