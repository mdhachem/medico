<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\GovernorateRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{

    /**
     * @Route("/dashboard", name="dashboard_admin")
     */
    public function index(UserRepository $repoU, ProductRepository $repoA, CategoryRepository $repoC)
    {
        return $this->render(
            'dashboard/index.html.twig',
            [
                'nb_user' => count($repoU->findAll()),
                'nb_post' => count($repoA->findAll()),
                'nb_category' => count($repoC->findAll()),

            ]


        );
    }
}
