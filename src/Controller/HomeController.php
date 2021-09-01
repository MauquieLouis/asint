<?php  
// src/Controller/HomeController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}

?>