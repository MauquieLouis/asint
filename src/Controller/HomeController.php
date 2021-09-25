<?php  
// src/Controller/HomeController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sport;
use App\Entity\Membre;
use App\Entity\Club;
use App\Form\AddMembreType;
use App\Form\AddSportType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(){
        //Function
        return $this->render('asint/home.html.twig',[]);
    }
    
    /**
     * @Route("/sports", name="sports")
     */
    public function sports(){
        $equipe = $this->getDoctrine()->getRepository(Membre::class)->findAll();
        $sports = $this->getDoctrine()->getRepository(Sport::class)->findAll();
        return $this->render('asint/sports.html.twig',['equipe' => $equipe, 'sports' => $sports]);
    }
    /**
     * @Route("/clubs", name="clubs")
     */
    public function clubs(){
        $clubs = $this->getDoctrine()->getRepository(Club::class)->findAll();
        return $this->render('asint/clubs.html.twig',['clubs' => $clubs]);
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
        $equipe = $this->getDoctrine()->getRepository(Membre::class)->findAll();
        return $this->render('asint/equipe.html.twig',['equipe' => $equipe]);
    }
    
    /**
     * @Route("/addsport", name="addSport")
     */
//     public function addSport(Request $request, SluggerInterface $slugger){
//         $sport = new Sport();
        
//         $form = $this->createForm(AddSportType::class, $sport);
        
//         $form->handleRequest($request);
//         if($form->isSubmitted() && $form->isValid()){
//             $sport = $form->getData();
            
//             $photo = $form->get('photo')->getData();
            
            
//             if($photo){
//                 $originalFilename = pathinfo($photo->getClientOriginalName(),PATHINFO_FILENAME);
//                 $safeFilename = $slugger->slug($originalFilename);
//                 $newFilename = $safeFilename.'-'.uniqid().'.'.pathinfo($photo->getClientOriginalName(),PATHINFO_EXTENSION);
                
//                 try{
//                     $photo->move($this->getParameter('photoSport_directory'), $newFilename);
                    
                    
//                 }catch(FileException $e){
//                     dd($e);
//                 }
//                 $sport->setPhoto($newFilename);
//             }
            
//             $em = $this->getDoctrine()->getManager();
//             $em->persist($sport);
//             $em->flush();
            
//             return $this->redirectToRoute('home');
//         }
//         return $this->render('asint/addSport.html.twig',['form' => $form->createView(),]);
//     }
    
    /**
     * @Route("/addmembre", name="addMembre")
     */
//     public function addMembre(Request $request, SluggerInterface $slugger){
//         $membre = new Membre();
        
//         $form = $this->createForm(AddMembreType::class, $membre);
        
//         $form->handleRequest($request);
//         if($form->isSubmitted() && $form->isValid()){
//             $membre = $form->getData();
            
//             $photo = $form->get('photo')->getData();
            
            
//             if($photo){
//                 $originalFilename = pathinfo($photo->getClientOriginalName(),PATHINFO_FILENAME);
//                 $safeFilename = $slugger->slug($originalFilename);
//                 $newFilename = $safeFilename.'-'.uniqid().'.'.pathinfo($photo->getClientOriginalName(),PATHINFO_EXTENSION);
                
//                 try{
//                     $photo->move($this->getParameter('photo_directory'), $newFilename);
                    
                 
//                 }catch(FileException $e){
//                     dd($e);    
//                 }
//                 $membre->setPhoto($newFilename);
//             }
 
//             $em = $this->getDoctrine()->getManager();
//             $em->persist($membre);
//             $em->flush();
            
//             return $this->redirectToRoute('home');
//         }
        
//         return $this->render('asint/addMembre.html.twig',['form' => $form->createView(),]);
//     }
}

?>