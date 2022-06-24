<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]


   public function test()
    {
        $prenom = 'Anie';
        $nom = "Balle";
    // crea de la variable 'personne' dans le tableau $identite 
        $identite = [
            'personne1' => 
            ['prenom' => 'Justine', 'nom' => 'Titegoute'], 
            'personne2' => 
            ['prenom' => 'Alain', 'nom' => 'Titegoute'] ];

        // foreach ($identite as $key => $value) {
        //         foreach ($value as $key => $value) {
        //             echo "$value";
        //         }
        // }

        
    // crea de la variable 'prenom' correspond a la clef $prenom 
    // pour affichage dans la page test.html.twig
        return $this->render("test.html.twig", [
            'prenom' => $prenom,
            'nom' => $nom,
            'identite' => $identite
        ]);
    }
    
}
