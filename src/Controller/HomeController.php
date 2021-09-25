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
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Cotisation;
use App\Form\CotisationType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
    public function new(Request $request): Response {
        $cotisation = new Cotisation();
        //$task->setTask('Write a blog post');
        //$task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($cotisation)
        //Nom, Prénom, Date de naissance, TSP ou IMT-BS, année(1A, 2A, 3A, bachelor), numéro de téléphone, salle, mail école, sports souhaités, soge ou pas, si soge demande du numéro de remise(option à venir)
            //->add('task', TextType::class)
            //->add('dueDate', DateType::class)
            //->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('naissance', DateType::class)
            ->add('ecole', ChoiceType::class)
            ->add('niveau', ChoiceType::class)

            ->add('telephone', TextType::class)
            ->add('mailEcole', EmailType::class)

            ->add('sportsSouhaites', TextType::class)

            ->add('duree', ChoiceType::class)
            
            ->add('optionSalle', ChoiceType::class)

            ->add('remiseSocieteGenerale', ChoiceType::class)

            ->getForm();
        
        $form = $this->createForm(CotisationType::class, $cotisation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $cotisation = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();
            $optionSalle= $form["optionSalle"]->getData();
            $remiseSocieteGenerale= $form["remiseSocieteGenerale"]->getData();
            $duree= $form["duree"]->getData();

            $salleSoge3ans = new UnicodeString('Vous pouvez maintenant cotiser <a href="https://billetterie.pumpkin-app.com/cotisation-asint-societe-generale-salle" target="_blank">ici</a>.');
            $salleNoSoge3ans = new UnicodeString('Vous pouvez maintenant cotiser <a href="https://billetterie.pumpkin-app.com/cotisation-asint-salle" target="_blank">ici</a>.');
            $noSalleSoge3ans = new UnicodeString('Vous pouvez maintenant cotiser <a href="https://billetterie.pumpkin-app.com/cotisation-asint-societe-generale" target="_blank">ici</a>.');
            $noSalleNoSoge3ans = new UnicodeString('Vous pouvez maintenant cotiser <a href="https://billetterie.pumpkin-app.com/cotisationasint" target="_blank">ici</a>.');

            $Salle1an = new UnicodeString('Vous pouvez maintenant cotiser <a href="https://billetterie.pumpkin-app.com/cotisation-asint-1-an-salle" target="_blank">ici</a>.');
            $noSalle1an = new UnicodeString('Vous pouvez maintenant cotiser <a href="https://billetterie.pumpkin-app.com/cotisation-asint-1-an" target="_blank">ici</a>.');
            
            $noSalle6mois = new UnicodeString('Vous pouvez maintenant cotiser <a href="https://billetterie.pumpkin-app.com/cotisation-asint-6-mois" target="_blank">ici</a>.');
            $salle6mois = new UnicodeString('Vous pouvez maintenant cotiser <a href="https://billetterie.pumpkin-app.com/cotisation-asint-6-mois-salle" target="_blank">ici</a>.');

            $lienCautionSoge = new UnicodeString(' </br> Pensez aussi à régler votre caution Société Générale <a href="https://perdu.com" target="_blank">ici</a>.');
            //$final = new UnicodeString(' </br> Pour finir transmetez le document suivant signé à <a href="https://www.facebook.com/hamzawou" target="_blank">Hamza Ouhhabi</a>.        ICI LIEN DOWNLOAD DOCUMENT');
            $final = new UnicodeString('');


            if ($form["ecole"]->getData() == 1 && $form["niveau"]->getData() == 4 ) {
                $this->addFlash('danger', 'Bonsoir non.');
            }

            elseif ($optionSalle == true && $remiseSocieteGenerale == true && $duree == 1) {
                $this->addFlash('success', $salleSoge3ans->append($lienCautionSoge)->append($final));
            }
            elseif ($optionSalle == true && $remiseSocieteGenerale == false && $duree == 1) {
                $this->addFlash('success', $salleNoSoge3ans->append($final));
            }
            elseif ($optionSalle == false && $remiseSocieteGenerale == true && $duree == 1) {
                $this->addFlash('success', $noSalleSoge3ans->append($lienCautionSoge)->append($final));
            }
            elseif ($optionSalle == false && $remiseSocieteGenerale == false && $duree == 1) {
                $this->addFlash('success', $noSalleNoSoge3ans->append($final));
            }
            //1 an
            elseif ($optionSalle == true && $remiseSocieteGenerale == false && $duree == 2) {
                $this->addFlash('success', $Salle1an)->append($final);
            }
            elseif ($optionSalle == false && $remiseSocieteGenerale == false && $duree == 2) {
                $this->addFlash('success', $noSalle1an->append($final));
            }
            //6 mois
            elseif ($optionSalle == true && $remiseSocieteGenerale == false && $duree == 3) {
                $this->addFlash('success', $salle6mois->append($final));
            }
            elseif ($optionSalle == false && $remiseSocieteGenerale == false && $duree == 3) {
                $this->addFlash('success', $noSalle6mois->append($final));
            }

            else {
                $this->addFlash('danger', 'Il est impossible de bénéficier de l\'offre Société Générale pour les cotisations inférieures à 3 ans.');
            }


            //return $this->redirectToRoute('home');
        }

        return $this->render('asint/cotiser.html.twig', [
            'form' => $form->createView(),
        ]);
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