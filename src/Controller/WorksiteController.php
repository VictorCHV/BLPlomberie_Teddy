<?php

namespace App\Controller;

use App\Entity\Worksite;
use App\Form\WorksiteType;
use App\Service\FileUploader;
use App\Form\SearchWorksiteType;
use App\DTO\SearchWorksiteCriteria;
use App\Repository\WorksiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 */

class WorksiteController extends AbstractController
{
    /**
     * @Route("/admin/chantier/nouveau", name="app_worksite_create")
     */
    public function create(Request $request, FileUploader $fileUploader, WorksiteRepository $repository): Response
    {
        // pas besoin d'ajouter l'objet Worksite en paramètre (car pas de préremplissage)
        $worksite= new Worksite();

        // création du formulaire
        $form= $this->createForm(WorksiteType::class, $worksite);

        // remplissage du formulaire & de l'objet php avec la requete
        $form->handleRequest($request);

        // test si formulaire est envoyé avec données valides
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $worksite->setImageFilename($imageFileName);
            }
            // récup données du formulaire dans l'objet worksite
            $validWorksite = $form->getData();
            // enregistrer les données du chantier dans la DB
            $repository->save($validWorksite, true);

            // redirection vers la liste des chantiers
            return $this->redirectToRoute('app_worksite_list');
        }

        // récup la view du formulaire
        $formView = $form->createView();

        // affichage dans le template
        return $this->render('worksite/create.html.twig', [
            'form' => $formView,
        ]);
    }

    /**
     * @Route("/admin/chantier/liste", name="app_worksite_list")
     */
    public function list(WorksiteRepository $repository): Response
    {
        // récup les chantiers depuis la DB
        $worksites = $repository->findAll(); //retourne liste des chantiers

        return $this->render('worksite/list.html.twig', [
            'worksites' => $worksites,
        ]);
    }

    /**
     * @Route("/admin/chantier/maj/{id}", name="app_worksite_update")
     */

     public function update(int $id, FileUploader $fileUploader, WorksiteRepository $repository, Request $request): Response
     {
         // récup données du chantier "cible" de l'id
         $worksite = $repository->find($id);

         // création du formulaire
         $form = $this->createForm(WorksiteType::class, $worksite);

         // remplissage du formulaire & de l'objet php avec la requete
         $form->handleRequest($request);

         //test si formulaire est envoyé avec données valides
         if ($form->isSubmitted() && $form->isValid()) {
             $imageFile = $form->get('image')->getData();
             if ($imageFile) {
                 $imageFileName = $fileUploader->upload($imageFile);
                 $worksite->setImageFilename($imageFileName);
             }


             // récup données du formulaire dans l'objet worksite
             $validWorksite = $form->getData();

             // enregistrer les données du chantier dans la DB
             $repository->save($validWorksite, true);

             // redirection vers la liste des chantiers
             return $this->redirectToRoute('app_worksite_list');
         }

         // récup la view du formulaire
         $formView = $form->createView();

         // affichage dans le template
         return $this->render('worksite/update.html.twig', [
             'form' => $formView,
             'worksite' => $worksite,
         ]);
     }

    /**
     * @Route("/admin/chantier/{id}/supprimer", name="app_worksite_remove")
     */
    public function remove(int $id, Request $request, WorksiteRepository $repository): Response
    {
        //recup le chantier depuis son id
        $worksite = $repository->find($id);

        //suprimer le chantier de la DB
        $repository->remove($worksite, true);

        // redirection vers la liste des chantiers
        return $this->redirectToRoute('app_worksite_list');
    }

    // fonction INUTILE (la recherche se fait dans le homeController)
    /**
     * @Route("/admin/chantier/search", name="app_worksite_search")
     */
    // public function search(WorksiteRepository $repository, Request $request): Response
    // {
    //     // 1. Création des critères de recherche
    //     $criteria = new SearchWorksiteCriteria();

    //     // 2. Création du formulaire
    //     $form = $this->createForm(SearchWorksiteType::class, $criteria);

    //     // 3. Remplir le formulaire avec les critères de recherche
    //     $form->handleRequest($request);

    //     // 4. récup les chantiers selon les critères donnés
    //     $worksites = $repository->findByCriteria($criteria);

    //     // 5. affichage du twig
    //     return $this->render('worksite/search.html.twig', [
    //         'form' => $form->createView(),
    //         'worksites' => $worksites
    //     ]);
    // }
}
