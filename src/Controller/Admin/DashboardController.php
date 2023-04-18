<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Entity\Customer;
use App\Entity\Menu;
use App\Entity\Restaurant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CustomerCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('QuaiAntique');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Acceuil', 'fa fa-home', 'home');
        yield MenuItem::linkToCrud('Les Clients', 'fas fa-user', Customer::class);
        yield MenuItem::linkToCrud('Le Restaurant', 'fas fa-utensils', Restaurant::class);
        yield MenuItem::linkToCrud('Les Réservations', 'fas fa-calendar-days', Booking::class);
        yield MenuItem::linkToCrud('Les Menus', 'fas fa-clipboard', Menu::class);
    }
}