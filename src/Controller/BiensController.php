<?php

namespace App\Controller;

use App\Entity\Biens;
use App\Entity\BiensSearch;
use App\Form\BiensSearchType;
use App\Repository\BiensRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(PaginatorInterface $paginator, Request $request): Response 
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


        $search = new BiensSearch();
        dump($search);
        $form = $this->createForm(BiensSearchType::class, $search);
        $form->handleRequest($request);

        $biens = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1), /*page number*/
            12
        );

        return $this->render('biens/index.html.twig', [
            'current_menu' => 'biens',
            'biens' => $biens,
            'form' => $form->createView()
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
