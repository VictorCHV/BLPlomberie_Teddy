<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\ListeChantiersRuntime;
use App\Repository\WorksiteRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ListeChantiersExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [ListeChantiersRuntime::class, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [ListeChantiersRuntime::class, 'doSomething']),
        ];
    }

    public function showroom(WorksiteRepository $repository, int $id): Response
    {
        // récup les chantiers de la catégorie cible depuis la BD
        $worksites= $repository->findTargetCategory($id);
        // afficher la page de résultats
        return render('no_admin/home/result.html.twig', [
         'worksites' => $worksites,
    ]);
    }
}
