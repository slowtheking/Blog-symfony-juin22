<?php

namespace App\Controller;

use App\Entity\Article;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{

    public function index(ManagerRegistry $doctrine): Response
    {
        // on cherche le dernier article inséré en BdD " $dernierArticle = "
        // en utilisant le repository de la class article ($doctrine->getRepository(Article::class))
        $dernierArticle = $doctrine->getRepository(Article::class)->findOneBy([],["dateDeCreation" => "DESC"]);
        
// dd dump and die pour verifier dernier article
      //  dd($dernierArticle);

        return $this->render('home/index.html.twig', [
            'dernierArticle' => $dernierArticle
        ]);
    }
}
