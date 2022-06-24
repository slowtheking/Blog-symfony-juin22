<?php
namespace App\Controller;

// ===== Importation des ENTITEES (CLASS) UTILISEES =====
use DateTime;
// symfony console doctrine:database:create
// symfony console make:entity NonArticle
use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController

// ========= Créer une route pour Afficher TOUS LES articles ======

{
    #[Route('/articles', name: 'app_articles')]
    // Indiquer la methode pour la fonction allArticles (ManagerRegistry $doctrine) = ManagerRegistry avec $doctrine
    public function allArticles(ManagerRegistry $doctrine): Response
    {

        // Recup tous les articles insérés en BdD 
        // en utilisant le Repository de la class article "getRepository(Article::class)->findAll()"
        $articles = $doctrine->getRepository(Article::class)->findAll();

        // dd($articles);  // Vérification comme (+ -) consol.log

        // DECLARER la variable ARTICLES qui sera utilisée dans la page |-> allArticles.html.twig
        return $this->render('article/allArticles.html.twig', [
            'articles' => $articles
        ]);
    }

    // ========= Créer une nouvelle route pour AJOUTER un NEW article ======

    #[Route('/ajout-article', name: 'ajout_article')]
    public function ajout(ManagerRegistry $doctrine, Request $request): Response
    {
        // Créa de l'OBJET article
        $article = new Article();

        // Créa du FORMulaire "$form = $this" 
        // En liant le FormType à l'objet créé "createForm(ArticleType::class, $article)"
        $form = $this->createForm(ArticleType::class, $article);

        // On donne acces aux données du formulaire pour la validation des données
        $form->handleRequest($request);

        // SI le formulaire est soumis "$form->isSubmitted()" et && valide "$form->isValid()"
        if ($form->isSubmitted() && $form->isValid()) {

            // AFFECTER les données manquantes [qui ne parviennent pas du formulaire ex: DateDeCreation]
            $article->setDateDeCreation(new DateTime("now"));

            // On recup le MANAGER de la DOCTRINE
            $manager = $doctrine->getManager();
            // On PERSIST [Conserve] l'objet $article
            $manager->persist($article);
            // Puis on envoie en BdD "flush()"
            $manager->flush();
            // rediriger vers la route des Articles 
            // -> #[Route('/articles', name: 'app_articles')]
            return $this->redirectToRoute("app_articles");
        }
            // chemin
        return $this->render("article/formulaire.html.twig", [
            'formArticle' => $form->createView()
        ]);
    }
    // ========= Créer une nouvelle route pour MODIFIER (mettre à jour) un ARTICLE ======

    #[Route('/update-article/{id}', name: 'article_update')]
    public function update(ManagerRegistry $doctrine, $id, Request $request): Response 
    // $id auras comme valeur l'ID passer en param de la ROUTE
    {
            // On RECUP l'article dont l'ID est passé en param de la fonction
            $article = $doctrine->getRepository(Article::class)->find($id);

            //==== Même FORMulaire que pour créer un Article

        // Créa du FORMulaire "$form = $this" 
        // En liant le FormType à l'objet créé "createForm(ArticleType::class, $article)"
        $form = $this->createForm(ArticleType::class, $article);

        // On donne acces aux données du formulaire pour la validation des données
        $form->handleRequest($request);

        // SI le formulaire est soumis "$form->isSubmitted()" et && valide "$form->isValid()"
        if ($form->isSubmitted() && $form->isValid()) {

            // AFFECTER les données manquantes [qui ne parviennent pas du formulaire ex: DateDeCreation]
            $article->setDateDeModification(new DateTime("now"));

            // On recup le MANAGER de la DOCTRINE
            $manager = $doctrine->getManager();
            // On PERSIST [Conserve] l'objet $article
            $manager->persist($article);
            // Puis on envoie en BdD "flush()"
            $manager->flush();
            // rediriger vers la route des Articles 
            // -> #[Route('/articles', name: 'app_articles')]
            return $this->redirectToRoute("app_articles");
        }
            // chemin vers le formulaire
        return $this->render("article/formulaire.html.twig", [
            'formArticle' => $form->createView()
        ]);
    }

    // ========= Créer une nouvelle route '/delete-article/{id}' pour SUPRIMER un ARTICLE ======

    #[Route('/delete-article/{id}', name: 'article_delete')]
    public function delete(ManagerRegistry $doctrine, $id, Request $request): Response 
    // $id auras comme valeur l'ID passer en param de la ROUTE
    {
  // On RECUP l'article dont l'ID est passé en param de la fonction
            $article = $doctrine->getRepository(Article::class)->find($id);

            // On recup le MANAGER de la DOCTRINE
            $manager = $doctrine->getManager();
            // On REMOVE l'objet $article
            $manager->remove($article);
            // Puis on envoie en BdD "flush()"
            $manager->flush();

            // rediriger vers la route des Articles 
            // -> #[Route('/delete-article/{id}', name: 'article_delete')]
            return $this->redirectToRoute("app_articles");
    }

    // ========= Créer une nouvelle route '/article/{id}' pour AFFICHER un ARTICLE ======

     #[Route('/article_{id}', name: 'app_articleshow')]
    public function showArticle(ManagerRegistry $doctrine, $id): Response 
    // $id auras comme valeur l'ID passer en param de la ROUTE
    {   
          // On RECUP l'article dont l'ID est passé en param de la fonction    
        $article = $doctrine->getRepository(Article::class)->find($id);

        return $this->render("article/unarticle.html.twig", [
            'article' => $article
        ]);
    }





}
