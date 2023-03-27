<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\WorksiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 */

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/catégorie/nouvelle", name="app_category_create")
     */
    public function create(Request $request, CategoryRepository $repository): Response
    {
        // pas besoin d'ajouter l'objet Category en paramètre (car pas de préremplissage)
        // $category= new Category();

        // création du formulaire
        $form= $this->createForm(CategoryType::class);

        // remplissage du formulaire & de l'objet php avec la requete
        $form->handleRequest($request);

        // test si formulaire est envoyé avec données valides
        if ($form->isSubmitted() && $form->isValid()) {
            // récup données du formulaire dans l'objet category
            $validCategory = $form->getData();
            // enregistrer les données de la catégorie dans la DB
            $repository->save($validCategory, true);

            // redirection vers la liste des catégories
            return $this->redirectToRoute('app_category_list');
        }

        // récup la view du formulaire
        $formView = $form->createView();

        // affichage dans le template
        return $this->render('category/create.html.twig', [
            'form' => $formView,
        ]);
    }

    /**
     * @Route("/admin/catégorie/liste", name="app_category_list")
     */
    public function list(CategoryRepository $repository): Response
    {
        // récup les catégories depuis la DB
        $categories = $repository->findAll(); //retourne liste des catégories

        return $this->render('category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("admin/catégorie/maj/{id}", name="app_category_update")
     */

     public function update(int $id, CategoryRepository $repository, Request $request): Response
     {
         // récup données de la catégorie "cible" de l'id
         $category = $repository->find($id);

         // création du formulaire
         $form = $this->createForm(CategoryType::class, $category);

         // remplissage du formulaire & de l'objet php avec la requete
         $form->handleRequest($request);

         // test si formulaire est envoyé avec données valides
         if ($form->isSubmitted() && $form->isValid()) {
             // récup données du formulaire dans l'objet catégorie
             $validCategory = $form->getData();

             // enregistrer les données de la catégorie dans la DB
             $repository->save($validCategory, true);

             // redirection vers la liste des catégories
             return $this->redirectToRoute('app_category_list');
         }

         // récup la view du formulaire
         $formView = $form->createView();

         // affichage dans le template
         return $this->render('category/update.html.twig', [
             'form' => $formView,
             'category' => $category,
         ]);
     }

    /**
     * @Route("/admin/catégorie/{id}/supprimer", name="app_category_remove")
     */
    public function remove(int $id, Request $request, CategoryRepository $repository): Response
    {
        // recup la catégorie depuis son id
        $category = $repository->find($id);

        // suprimer la catégorie de la DB
        $repository->remove($category, true);

        // redirection vers la liste des catégories
        return $this->redirectToRoute('app_category_list');
    }

    /**
     * @Route("admin/catégorie/{id}" , name="app_category_display")
     */
    // voir si on SUPPRIME !!!!!

    // public function display(int $id, WorksiteRepository $repository, CategoryRepository $catrepo): Response
    // {
    //     // récup les kkkkkkkkkkkkkkkkkk de la catégorie ciblée
    //     $worksites= $repository->findTargetCategory($id);
    //     $category = $catrepo->find($id);

    //     // afficher la page de résultats
    //     return $this->render('category/result.html.twig', [
    //         'worksites' => $worksites,
    //         'category' => $category,
    //     ]);
    // }
}
