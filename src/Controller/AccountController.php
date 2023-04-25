<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Customer;
use App\Form\CustomerInfoFormType;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function edit(Request $request, EntityManagerInterface $manager, RestaurantRepository $restaurantRepository): Response
    {
        $customer = new Customer();
        $customer = $this->getUser();

        $nbBooking = false;
        $booking = $manager->getRepository(Booking::class)->findByCustomer($customer);

        if ($booking !== []) {
           $nbBooking = true;
        }

        $form = $this->createForm(CustomerInfoFormType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $manager->persist($customer);
            $manager->flush();

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/index.html.twig', [
            'CustomerInfoForm' => $form->createView(),
            'booking' => $nbBooking,
            'Restaurant' => $restaurantRepository->findAll(),
        ]);
    }
}
