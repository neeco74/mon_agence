<?php

namespace App\Controller;

use App\Entity\Biens;
use App\Repository\BiensRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BiensController extends AbstractController
{
        /**
     * @var repo
     */
    private $repository;

    /**
     * @var 
     */
    private $em;


    public function __construct(BiensRepository $repo, EntityManagerInterface $em)
    {
    
        $this->repository = $repo;   
        $this->em = $em;   
    }

    /**
     * @Route("/biens", name="biens_index")
     * @return Response
     */
    public function index(): Response
    {
        // $bien = new Biens();
        // $bien->setTitre('Mon premier bien')
        //             ->setPrice(200000)
        //             ->setRooms(4)
        //             ->setBedrooms(3)
        //             ->setDescription('Une petite descripion')
        //             ->setSurface(60)
        //             ->setFloor(4)
        //             ->setHeat(1)
        //             ->setCity('Montpellier')
        //             ->setAddress('15 Boulevard Gambetta')
        //             ->setPostalCode('34000');

        // $em = $this->getDoctrine()->getManager();
        // $em->persist($bien);
        // $em->flush(); 

        $bien = $this->repository->findAllVisible();
        dump($bien);

        return $this->render('biens/index.html.twig', [
            'current_menu' => 'biens'
        ]);

    }


   /**
     * @Route("/biens/{slug}-{id}", name="biens_show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Biens $bien, string $slug): Response {


        if($bien->getSlug() !== $slug){
            return $this->redirectToRoute('property_show', [
                'id' => $bien->getId(),
                'slug' => $bien->getSlug()

            ], 301);
        }


        return $this->render('biens/show.html.twig', [
            'bien' => $bien,
            'current_menu' => 'biens'
            
        ]);
        
    } 












}
