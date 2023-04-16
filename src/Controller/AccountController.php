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
    #[Route('/account/{id}', name: 'app_account', methods: ['GET', 'POST'])]
    public function edit(Customer $customer, Request $request, EntityManagerInterface $manager, RestaurantRepository $restaurantRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        if ($this->getUser() !== $customer) {
            return $this->redirectToRoute('home');
        }

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

            return $this->redirectToRoute('app_account', ['id' => $customer->getId()]);
        }

        return $this->render('account/index.html.twig', [
            'CustomerInfoForm' => $form->createView(),
            'booking' => $nbBooking,
            'Restaurant' => $restaurantRepository->findAll(),
        ]);
    }
}
