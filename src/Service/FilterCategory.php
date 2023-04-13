<?php

// src/Service/MyService.php

namespace App\Service;

use App\Repository\WorksiteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilterCategory extends AbstractController
{
    public function showroom(WorksiteRepository $repository, int $id): Response
    {
        // récup les chantiers de la catégorie cible depuis la BD
        $worksites= $repository->findTargetCategory($id);
        // afficher la page de résultats
        return $this->render('no_admin/home/result.html.twig', [
         'worksites' => $worksites,
    ]);
    }
}
