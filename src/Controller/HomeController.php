<?php  
// src/Controller/HomeController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// - - - - - - - E N T I T Y - - - - - - - - //
use App\Entity\Sport;
use App\Entity\Membre;
use App\Entity\Club;
use App\Entity\Cotisation;

// - - - - - - - - F O R M - - - - - - - - - //
use App\Form\CotisationType;
use Symfony\Component\String\UnicodeString;


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
     * @Route("/cotiser", name="cotiser")
     */
    public function cotiser(Request $request){
        $cotis = new Cotisation();
        $form = $this->createForm(CotisationType::class, $cotis);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $cotis = $form->getData();
            if ($form["ecole"]->getData() == 1 && $form["niveau"]->getData() == 4 ) {
                $this->addFlash('danger', 'Bonsoir non.');
                //rediriger avec message d'erreur (bachelor + TSP = Impossible)
            }
            $lien = $this->makeLink($form["optionSalle"]->getData(), $form["remiseSoge"]->getData(),$form["duree"]->getData());
            $cotis->setLien($lien);
            $cotis->setValide(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($cotis);
            $em->flush();
            //redirection page d'acceuil avec message confirmation contenant le lien
            //Eventuellement à changer plus tard (truc plus sécu)
            $message = new UnicodeString('Vous pouvez maintenant cotiser <a href="'.$lien.'" target="_blank">ICI</a>');
            $final = new UnicodeString('');
            $this->addFlash('success', $message->append($final));
            if($lien == "https://www.instagram.com/jlmz51/"){
                $this->addFlash('danger', 'Une erreur est survenue, merci de recommencer');
            }
            return $this->redirectToRoute('home');
        }
        return $this->render('asint/cotiser.html.twig',['form' => $form->createView(),]);
    }
    
    
    private function makeLink($salle,$soge,$duree){
        switch($duree){
            case 1: // => 3 ans | SOGE POSSIBLE
                if($soge){
                    if($salle){
                        //LIEN SOGE+SALLE+3ANS
                        $link = "https://billetterie.pumpkin-app.com/cotisation-asint-societe-generale-salle";
                    }else{
                        //LIEN SOGE+3ANS
                        $link="https://billetterie.pumpkin-app.com/cotisation-asint-societe-generale";
                    }
                }else{
                    if($salle){
                        //LIEN SALLE+3ANS 
                        $link="https://billetterie.pumpkin-app.com/cotisation-asint-salle";
                    }else{
                        //LIEN 3ANS
                        $link="https://billetterie.pumpkin-app.com/cotisationasint";
                    }
                }
            break;
            case 2: // => 1 ans | PAS DE SOGE   
                if($salle){
                    //LIEN SALLE+1ANS
                    $link="https://billetterie.pumpkin-app.com/cotisation-asint-1-an-salle";
                }else{
                    //LIEN 1ANS
                    $link="https://billetterie.pumpkin-app.com/cotisation-asint-1-an";
                }
            break;
            case 3: // => 6 mois | PAS DE SOGE
                if($salle){
                    //LIENS SALLE+6MOIS
                    $link="https://billetterie.pumpkin-app.com/cotisation-asint-6-mois-salle";
                }else{
                    //LIENS 6MOIS
                    $link="https://billetterie.pumpkin-app.com/cotisation-asint-6-mois";
                }
            break;
            default:
                $link="https://www.instagram.com/jlmz51/";
            break;
        }
        return $link;
    }
}

?>