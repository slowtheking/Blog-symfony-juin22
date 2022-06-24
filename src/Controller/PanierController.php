<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function affichePanier()
    {
              $panier = [
            'produit1' => 
            ['id' => '001', 
            'titre' => 'produit 1', 
            'description' => 'description 1',
            'prix' => 'prix: 10'], 

            'produit2' => 
            ['id' => '002', 
            'titre' => 'produit 2', 
            'description' => 'description 2',
            'prix' => 'prix: 20'], 

            'produit3' => 
            ['id' => '003', 
            'titre' => 'produit 3', 
            'description' => 'description 3',
            'prix' => 'prix: 30 '], 

            'produit4' => 
            ['id' => '004', 
            'titre' => 'produit 4', 
            'description' => 'description 4',
            'prix' => 'prix: 40']
            ] ;

        return $this->render('panier.html.twig', [
            'panier' => $panier,
        ]);
    }
}
