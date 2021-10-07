<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

// - - - - - - - - - - - E N T I T Y - - - - - - - - - - //
use App\Entity\Sport;
use App\Entity\Membre;
use App\Entity\Club;

// - - - - - - - - - - - - F O R M - - - - - - - - - - - //
use App\Form\AddMembreType;
use App\Form\AddSportType;
use App\Form\AddClubType;

// - - - - - - - - - R E P O S I T O R Y - - - - - - - - //
use App\Repository\MembreRepository;
use App\Repository\SportRepository;
use App\Repository\ClubRepository;
use App\Repository\CotisationRepository;
use App\Entity\Cotisation;

/**
 * @IsGranted("ROLE_ADMIN")
 * @author Louis
 *
 */
class AdminController extends AbstractController
{
    
    private $mR;
    private $sR;
    private $cR;
    private $coR;
    
    public function __construct(MembreRepository $mR, SportRepository $sR, ClubRepository $cR, CotisationRepository $coR){
        $this->mR=$mR;
        $this->sR=$sR;
        $this->cR=$cR;
        $this->coR=$coR;
    }
    /**
     * @Route("/jeanmichlazone91/index", name="admin91")
     */
    public function index(Request $request)
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    
    /**
     * @Route("/jeanmichlazone91/membre/{idty}", name="membre")
     */
    public function membreForm(Request $request, SluggerInterface $slugger, string $idty = 'new'){
        $listMembre = $this->mR->findAll();
        if($idty == 'new'){
            $membre = new Membre();
            $form = $this->createForm(AddMembreType::class, $membre);
        }else{
            $membre = $this->mR->findOneBy(['id' => intval($idty)]);
            $form = $this->createForm(AddMembreType::class, $membre);
        }
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //On update les champs un par un.
            $membre = $form->getData();
            $photo = $form->get('photo')->getData();
            if($photo){
                $originalFilename = pathinfo($photo->getClientOriginalName(),PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.pathinfo($photo->getClientOriginalName(),PATHINFO_EXTENSION);
                
                try{
                    $photo->move($this->getParameter('photo_directory'), $newFilename);
                    
                    
                }catch(FileException $e){
                    dd($e);
                }
                $membre->setPhoto($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();
            
            return $this->redirectToRoute('membre');
        }
        return $this->render('admin/membre.html.twig',['form' => $form->createView(),'membres'=> $listMembre]);
    }
    
    /**
     * @Route("/jeanmichlazone91/membre/{idty}/delete", name="membreDelete")
     */
    public function membreDelete(Request $request, string $idty){
        $em = $this->getDoctrine()->getManager();
        $membre = $this->mR->findOneBy(['id' => intval($idty)]);
        $em->remove($membre);
        $em->flush();
        return $this->redirectToRoute('membre');
    }
    
    /**
     * @Route("/jeanmichlazone91/sport/{idty}", name="sport")
     */
    public function sport(Request $request, SluggerInterface $slugger, string $idty='new'){
        $listSports = $this->sR->findAll();
        if($idty == 'new'){
            $sport = new Sport();
            $form = $this->createForm(AddSportType::class, $sport);
        }else{
            $sport = $this->sR->findOneBy(['id' => intval($idty)]);
            $form = $this->createForm(AddSportType::class, $sport);
        }
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $sport = $form->getData();
            
            $photo = $form->get('photo')->getData();
            
            
            if($photo){
                $originalFilename = pathinfo($photo->getClientOriginalName(),PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.pathinfo($photo->getClientOriginalName(),PATHINFO_EXTENSION);
                
                try{
                    $photo->move($this->getParameter('photoSport_directory'), $newFilename);
                    
                    
                }catch(FileException $e){
                    dd($e);
                }
                $sport->setPhoto($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($sport);
            $em->flush();
            
            return $this->redirectToRoute('sport');
        }
        
        return $this->render('admin/sport.html.twig',['form' => $form->createView(),'sports'=> $listSports]);
    }
    /**
     * @Route("/jeanmichlazone91/sport/{idty}/delete", name="sportDelete")
     */
    public function sportDelete(Request $request, string $idty){
        $em = $this->getDoctrine()->getManager();
        $sport = $this->sR->findOneBy(['id' => intval($idty)]);
        $em->remove($sport);
        $em->flush();
        return $this->redirectToRoute('sport');
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////
    //------------------------------------C L U B-----------------------------------------//
    ////////////////////////////////////////////////////////////////////////////////////////
    /**
     * @Route("/jeanmichlazone91/club/{idty}", name="club")
     */
    public function club(Request $request, SluggerInterface $slugger, string $idty='new'){
        $clubs = $this->cR->findAll();
        if($idty == 'new'){
            $club = new Club();
            $form = $this->createForm(AddClubType::class, $club);
        }else{
            $club = $this->cR->findOneBy(['id' => intval($idty)]);
            $form = $this->createForm(AddClubType::class, $club);
        }
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $club = $form->getData();
            
            $photo = $form->get('photo')->getData();
            
            
            if($photo){
                $originalFilename = pathinfo($photo->getClientOriginalName(),PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.pathinfo($photo->getClientOriginalName(),PATHINFO_EXTENSION);
                
                try{
                    $photo->move($this->getParameter('photoClub_directory'), $newFilename);
                    
                    
                }catch(FileException $e){
                    dd($e);
                }
                $club->setPhoto($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            
            return $this->redirectToRoute('club');
        }
        
        return $this->render('admin/club.html.twig',['form' => $form->createView(),'clubs'=> $clubs]);
    }
    /**
     * @Route("/jeanmichlazone91/club/{idty}/delete", name="clubDelete")
     */
    public function clubDelete(Request $request, string $idty){
        $em = $this->getDoctrine()->getManager();
        $club = $this->cR->findOneBy(['id' => intval($idty)]);
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute('club');
    }
    
    /**
     * @Route ("/jeanmichlazone91/liste/cotisation", name="listeCotis")
     */
    public function listeCotis(Request $request){
        $listeCotis = $this->coR->findBy(['valide' => false]);
        return $this->render('admin/listeCotis.html.twig',['listeCotis' => $listeCotis]);
    }
    
    /**
     * @Route("jeanmichlazone91/valid/cotis/{id}", name="validCotis")
     */
    public function validCotis(Cotisation $cotis){
        $cotis->setValide(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($cotis);
        $em->flush();
        $this->addFlash('success', 'Cotisation de '.$cotis->getNom().' '.$cotis->getPrenom().' validé.');
        // AJOUTER ENREGISTREMENT BDD GALETTE.
        return $this->redirectToRoute('listeCotis');
    }
}
