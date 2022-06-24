<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Controller\AuteurController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuteurController extends AbstractController



{
    // ========= Créer une route pour Afficher TOUS LES auteurs ======

    #[Route('/auteurs', name: 'app_auteurs')]
    public function allAuteurs(ManagerRegistry $doctrine): Response
    {
        // Recup tous les AUTEURS insérés en BdD 
        $auteurs = $doctrine->getRepository(Auteur::class)->findAll();
        // DECLARER la variable AUTEURS qui sera utilisée dans la page |-> allAuteurs.html.twig
        return $this->render('auteur/allAuteurs.html.twig', [
            'auteurs' => $auteurs
        ]);
    }

    // ========= Créer une route pour AJOUTER un NEW auteur ======

    #[Route('/ajout-auteur', name: 'ajout_auteur')]
    public function ajout(ManagerRegistry $doctrine, Request $request): Response
    {
        $auteur = new Auteur(); // Créa de l'OBJET
        $form = $this->createForm(AuteurType::class, $auteur); // Créa du FORMulaire
        $form->handleRequest($request); // On donne acces aux données du formulaire

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $doctrine->getManager(); // On recup le MANAGER           
            $manager->persist($auteur);  // On PERSIST l'objet $auteur            
            $manager->flush(); // Puis on envoie en BdD "flush()"
            return $this->redirectToRoute("app_auteurs");  // rediriger vers la route des Auteurs
        }
        return $this->render("auteur/formAuteur.html.twig", [
            'formAuteur' => $form->createview()
        ]);  // chemin et affiche
    }

    // ========= Route pour RECUP un AUTEUR ======
    // {id<\d+>} pour spécifier que c'est un nombre <\d+>

    #[Route('/auteur_{id<\d+>}', name: 'app_voirAuteur')]
    public function showAuteur(ManagerRegistry $doctrine, $id): Response
    {
        $auteur = $doctrine->getRepository(Auteur::class)->find($id); // On RECUP l'auteur
        // chemin vers unauteur.html.twig
        return $this->render("auteur/unauteur.html.twig", [
            'auteur' => $auteur
        ]);
    }

    // ========= Route pour MODIFIER (MàJ) un AUTEUR ======
    // {id<\d+>} pour spécifier que c'est un nombre <\d+>

    #[Route('update-auteur_{id<\d+>}', name: 'auteur_update')]
    public function update(ManagerRegistry $doctrine, $id, Request $request): Response
    {
        $auteur = $doctrine->getRepository(Auteur::class)->find($id); // On RECUP l'auteur avec l'ID
        $form = $this->createForm(AuteurType::class, $auteur); // Créa du FORMulaire
        $form->handleRequest($request); // Acces aux données du formulaire pour validation 

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $doctrine->getManager(); // On recup le MANAGER
            $manager->persist($auteur);  // On PERSIST l'objet $auteur
            $manager->flush();  // Puis on envoie en BdD "flush()"
            return $this->redirectToRoute("app_auteurs"); // Redirect vers la route ds Auteurs
        }
        // chemin vers le formulaire
        return $this->render("auteur/formAuteur.html.twig", [
            'formAuteur' => $form->createView()
        ]);
    }

    // ========= Route (Methode) pour SUPRIMER un AUTEUR ======
    // {id<\d+>} pour spécifier que c'est un nombre <\d+>

    #[Route('/delete-auteur/{id<\d+>}', name: 'auteur_delete')]
    public function delete(ManagerRegistry $doctrine, $id, Request $request): Response
    {
        $auteur = $doctrine->getRepository(Auteur::class)->find($id); // On RECUP l'Auteur by l'ID
        $manager = $doctrine->getManager(); // On recup le MANAGER
        $manager->remove($auteur); // On REMOVE l'objet $auteur
        $manager->flush(); // Puis on envoie en BdD "flush()"

        return $this->redirectToRoute("app_auteurs"); // REDIRECT vers la route des Auteurs
    }
}
