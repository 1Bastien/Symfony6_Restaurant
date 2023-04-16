<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'Restaurant' => $restaurantRepository->findAll(),
        ]);
    }
}
