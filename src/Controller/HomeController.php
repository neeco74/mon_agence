<?php

namespace App\Controller;

use App\Repository\BiensRepository;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {
   
   
    // /**
    //  * @var Environnment
    //  */
    // private $twig;



    // public function __construct(Environment $twig) {

    //     $this->twig = $twig;
    // }

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(BiensRepository $repo): Response {

        $biensLatest = $repo->findLatest();
        return $this->render('pages/home.html.twig', [
            'biensLatest' => $biensLatest
        ]);

    } 

}
