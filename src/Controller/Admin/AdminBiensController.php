<?php

namespace App\Controller\Admin;


use App\Entity\Biens;

use App\Form\BiensType;
use App\Repository\BiensRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminBiensController extends AbstractController {

    /**
     * @var PropertyRepository
     */
    private $br;

    public function __construct(BiensRepository $br, EntityManagerInterface $em) {

        $this->br = $br;
        $this->em = $em;   
    }

    /**
     * @Route("/admin", name="admin_biens_index")
     * @param PropertyRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index() {

        $biens = $this->br->findAll();
        return $this->render('admin/biens/index.html.twig', compact('biens'));
    }  
    
    

    /**
     * @Route("/admin/biens/create", name="admin_biens_new")
     * @param 
     * @return 
     */
    public function new(Request $request) {
        
        $bien = new Biens();
        $form = $this->createForm(BiensType::class, $bien);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($bien);
            $this->em->flush();
            $this->addFlash('success', 'Bien créé avec succès');
            return $this->redirectToRoute('admin_biens_index');
        } 

        return $this->render('admin/biens/new.html.twig', [
            'bien' => $bien,
            'form' => $form->createView()
        ]);
    }  
    
    
    /**
    * @Route("/admin/biens/{id}", name="admin_biens_edit", methods="GET|POST")
    * @param PropertyRepository $repository
    * @return Response
    */
   public function edit(Biens $bien, Request $request, CacheManager $cacheManager, UploaderHelper $helper) {

        $form = $this->createForm(BiensType::class, $bien);
        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()) {
            if($bien->getImageFile() instanceof UploadedFile) {
                $cacheManager->remove($helper->asset($bien, 'imageFile'));
            }


            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin_biens_index');
        }



        return $this->render('admin/biens/edit.html.twig', [
           'bien' => $bien,
           'form' => $form->createView()
           
       ]);
   

   }

    /**
     * @Route("/admin/biens/{id}", name="admin_biens_delete", methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Biens $bien, Request $request) {
        if($this->isCsrfTokenValid('delete' . $bien->getId(), $request->get('_token'))){
 
            dump('suppression');
            //$this->emi->remove($property);
            //$this->emi->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');
            return new Response('Suppression');
            
        }
        return $this->redirectToRoute('admin_property_index');
    }

}