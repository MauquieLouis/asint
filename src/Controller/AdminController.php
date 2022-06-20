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
use App\Entity\Evenement;
use App\Entity\Partenaire;
use App\Entity\Cotisation;
use App\Entity\Year;

// - - - - - - - - - - - - F O R M - - - - - - - - - - - //
use App\Form\AddMembreType;
use App\Form\AddSportType;
use App\Form\AddClubType;
use App\Form\PartenaireType;
use App\Form\EvenementType;
use App\Form\YearFormType;

// - - - - - - - - - R E P O S I T O R Y - - - - - - - - //
use App\Repository\MembreRepository;
use App\Repository\SportRepository;
use App\Repository\ClubRepository;
use App\Repository\CotisationRepository;
use App\Repository\PartenaireRepository;
use App\Repository\EvenementRepository;
use App\Repository\YearRepository;

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
    private $pR;
    private $eR;
    private $yR;
    
    public function __construct(MembreRepository $mR,
        SportRepository $sR,
        ClubRepository $cR,
        CotisationRepository $coR,
        PartenaireRepository $pR,
        EvenementRepository $eR,
        YearRepository $yR
        ){
        $this->mR=$mR;
        $this->sR=$sR;
        $this->cR=$cR;
        $this->coR=$coR;
        $this->pR=$pR;
        $this->eR=$eR;   
        $this->yR=$yR;
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
    //================================================================================//
    //=========================== M E M B R E S ======================================//
    //================================================================================//
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
    //================================================================================//
    //============================== S P O R T =======================================//
    //================================================================================//
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
    
    //================================================================================//
    //============================== C L U B S =======================================//
    //================================================================================//
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
     * @Route("jeanmichlazone91/partenaires/{idty}", name="partenaire")
     */
    public function partenaires(Request $request, SluggerInterface $slugger, string $idty='new'){
        $partenaires = $this->pR->findAll();
        if($idty == 'new'){
            $partenaire = new Partenaire();
            $form = $this->createForm(PartenaireType::class, $partenaire);
        }else{
            $partenaire = $this->pR->findOneBy(['id' => intval($idty)]);
            $form = $this->createForm(PartenaireType::class, $partenaire);
        }
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $partenaire = $form->getData();
            
            $photo = $form->get('photo')->getData();
            
            
            if($photo){
                $originalFilename = pathinfo($photo->getClientOriginalName(),PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.pathinfo($photo->getClientOriginalName(),PATHINFO_EXTENSION);
                
                try{
                    $photo->move($this->getParameter('photoPartenaire_directory'), $newFilename);
                    
                    
                }catch(FileException $e){
                    dd($e);
                }
                $partenaire->setPhoto($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($partenaire);
            $em->flush();
            
            return $this->redirectToRoute('partenaire');
        }
        
        return $this->render('admin/partenaire.html.twig',['form' => $form->createView(),'partenaires'=> $partenaires]);
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
     * @Route("/jeanmichlazone91/partenaire/{idty}/delete", name="partenaireDelete")
     */
    public function partenaireDelete(Request $request, string $idty){
        $em = $this->getDoctrine()->getManager();
        $partenaire = $this->pR->findOneBy(['id' => intval($idty)]);
        $em->remove($partenaire);
        $em->flush();
        return $this->redirectToRoute('partenaire');
    }
    
    //================================================================================//
    //===========================E V E N E M E N T ===================================//
    //================================================================================//
    /**
     * @Route("jeanmichlazone91/evenement/{idty}", name="evenement")
     */
    public function evenements(Request $request, SluggerInterface $slugger, string $idty='new'){
        $evenements = $this->eR->findAll();
        if($idty == 'new'){
            $evenement = new Evenement();
            $form = $this->createForm(EvenementType::class, $evenement);
        }else{
            $evenement = $this->eR->findOneBy(['id' => intval($idty)]);
            $form = $this->createForm(EvenementType::class, $evenement);
        }
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $evenement = $form->getData();
            
//             $photo = $form->get('photo')->getData();
            
            
//             if($photo){
//                 $originalFilename = pathinfo($photo->getClientOriginalName(),PATHINFO_FILENAME);
//                 $safeFilename = $slugger->slug($originalFilename);
//                 $newFilename = $safeFilename.'-'.uniqid().'.'.pathinfo($photo->getClientOriginalName(),PATHINFO_EXTENSION);
                
//                 try{
//                     $photo->move($this->getParameter('photoPartenaire_directory'), $newFilename);
                    
                    
//                 }catch(FileException $e){
//                     dd($e);
//                 }
//                 $evenement->setPhoto($newFilename);
//             }
            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            
            return $this->redirectToRoute('evenement');
        }
        
        return $this->render('admin/evenement.html.twig',['form' => $form->createView(),'evenements'=> $evenements]);
    }
    /**
     * @Route("/jeanmichlazone91/evenement/{idty}/delete", name="evenementDelete")
     */
    public function evenementsDelete(Request $request, string $idty){
        $em = $this->getDoctrine()->getManager();
        $evenement = $this->eR->findOneBy(['id' => intval($idty)]);
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('evenement');
    }

    //================================================================================//
    //============================== A N N E E S =====================================//
    //================================================================================//
    /**
     * @Route ("/jeanmichlazone91/year/{idty}", name="year")
     */
    public function yearsSettings(Request $request, string $idty = 'new'){
//         if($idty == 'new'){
        $year = new Year();
//         }else{
//             $year = $this->yR->findOneBy(['id' => intval($idty)]);
//         }
        $annees = $this->yR->findAll();
        $form = $this->createForm(YearFormType::class, $year);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $year = $form->getData();
            $activeYears = $this->yR->findBy(['active' => true]);
            foreach($activeYears as $y){
                $y->setActive(false);
                $em->persist($y);
            }
            if($this->yR->findOneBy(['year' => $year->getYear()])){
                  dd("This year already exist");
            }
//             dd($year);
            $em->persist($year);
            $em->flush();
            //Afficher message
            return $this->redirectToRoute('year');
        }
            
//             return $this->redirectToRoute('membre');
        return $this->render('admin/year.html.twig',['form' => $form->createView(), 'annees'=>$annees]);
    }
    /**
     * @Route("/jeanmichlazone91/year/delete/{id}/", name="yearDelete")
     */
    public function deleteYear(Request $request, string $id){
        $currentYear = date("Y");
//         dd($currentYear);
        $year = $this->yR->findOneBy(['id' => intval($id)]);
        if($currentYear > $year->getYear()){
            //Message impossible de suppr car année passé
            dd("Impossible de supprimer cette année, car elle est passée ...");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($year);
        $em->flush();
        return $this->redirectToRoute('evenement');
    }
    
    /**
     * @Route("/jeanmichlazone91/year/putActive/{id}/", name="putActive")
     */
//     public function putActiveYear(Request $request, string $id){
//         $year = $this->yR->findOneBy(['id' => intval($id)]);
//     }
    
    //================================================================================//
    //========================= C O T I S A T I O N S ================================//
    //================================================================================//
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
