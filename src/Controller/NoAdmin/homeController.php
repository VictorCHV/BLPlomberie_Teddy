<?php

namespace App\Controller\NoAdmin;

use App\Form\SearchWorksiteType;
use App\DTO\SearchWorksiteCriteria;
use App\Repository\WorksiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class homeController extends AbstractController
{
    /**
     * @Route("/noadmin/accueil" , name="app_NoAdmin_home_home")
     */
    public function home(): Response
    {
        return $this->render('no_admin/home/home.html.twig', [
            'controller_name' => 'homeController',
        ]);
    }

    /**
     * @Route("/noadmin/home/services" , name="app_NoAdmin_home_services")
     */
    public function services(): Response
    {
        return $this->render('no_admin/home/services.html.twig', [
            'controller_name' => 'homeController',
        ]);
    }

    /**
     * @Route("/noadmin/home/zone_intervention" , name="app_NoAdmin_home_area")
     */
    public function area(): Response
    {
        return $this->render('no_admin/home/area.html.twig', [
            'controller_name' => 'homeController',
        ]);
    }

    /**
     * @Route("/noadmin/home/contact" , name="app_NoAdmin_home_contact")
     */
    public function contact(): Response
    {
        return $this->render('no_admin/home/contact.html.twig', [
            'controller_name' => 'homeController',
        ]);
    }


    /**
     * @Route("/noadmin/home/showroom" , name="app_NoAdmin_home_showroom")
     */
    public function showroom(WorksiteRepository $repository): Response
    {
        // récup les chantiers depuis la BD
        $worksites= $repository->findAll();

        // afficher la page de résultats
        return $this->render('no_admin/home/result.html.twig', [
            'worksites' => $worksites,
        ]);
    }

    /**
     * @Route("/noadmin/home/search" , name="app_NoAdmin_home_search")
     */
    public function search(WorksiteRepository $repository, Request $request): Response
    {
        // 1. Création des critères de recherche
        $criteria = new SearchWorksiteCriteria();

        // 2. Création du formulaire
        $form = $this->createForm(SearchWorksiteType::class, $criteria);

        // 3. Remplir le formulaire avec les critères de recherche de l'utilisateur
        $form->handleRequest($request);

        // 4. récup les chantiers selon les critères
        $worksites = $repository->findByCriteria($criteria);

        // 5. affichage du twig
        return $this->render('no_admin/home/search.html.twig', [
            'form' => $form->createView(),
            'worksites' => $worksites
        ]);
    }
}
