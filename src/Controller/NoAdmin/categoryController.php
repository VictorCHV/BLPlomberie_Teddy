<?php

namespace App\Controller\NoAdmin;

use App\Repository\CategoryRepository;
use App\Repository\WorksiteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class categoryController extends AbstractController
{
    /**
     * @Route("/noadmin/catégorie/{id}" , name="app_NoAdmin_category_display")
     */
    public function display(int $id, WorksiteRepository $repository, CategoryRepository $catrepo): Response
    {
        // récup les chantiers de la catégorie ciblée
        $worksites = $repository->findTargetCategory($id);
        $category = $catrepo->find($id);

        // afficher la page de résultats
        return $this->render('no_admin/category/result.html.twig', [
            'worksites' => $worksites,
            'category' => $category,
        ]);
    }
}
