<?php

namespace App\Controller\Admin;


use App\Entity\Biens;

use App\Entity\Images;
use App\Form\BiensType;
use App\Repository\BiensRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


use Symfony\Component\Routing\Annotation\Route;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\JsonResponse;
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
                        // On recupere les images transmises
                        $images = $form->get('images')->getData();

                        // On boucle sur les images
                        foreach ($images as $image) {
                            //On genere un nouveau nom de fichier
                            $fichier = md5(uniqid()) . '.' . $image->guessExtension();
            
                            //On copie le fichier dans le dossier uploads
                            $image->move(
                                $this->getParameter('images_directory'),      // Va recuperer la variable du services.yaml
                                $fichier
                            );
            
                            // On stocke l'image dans la bdd (son nom)
                            $img = new Images();
                            $img->setName($fichier);
                            $bien->addImage($img);
                        }

                        
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
            // On recupere les images transmises
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach ($images as $image) {
                //On genere un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                //On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),      // Va recuperer la variable du services.yaml
                    $fichier
                );

                // On stocke l'image dans la bdd (son nom)
                $img = new Images();
                $img->setName($fichier);
                $bien->addImage($img);
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

    /**
     * @Route("/admin/image/delete/{id}", name="admin_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Images $image, Request $request) {
        $data = json_decode($request->getContent(), true);
        
        if($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])){
            $nom = $image->getName();
            unlink($this->getParameter('images_directory').'/'.$nom);
            
            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();
            
            // On répond en json
            return new JsonResponse(['success' => 1]);
        }
        else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }

    }

}