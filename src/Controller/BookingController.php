<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\BookingFormType;
use App\Entity\Booking;
use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class BookingController extends AbstractController
{
    #[Route('/booking/{date}/{nbGuests}', name: 'booking_customer')]
    public function bookingCustomer(int $nbGuests, string $date, Request $request, EntityManagerInterface $manager, RestaurantRepository $restaurantRepository): Response
    {
        $booking = new Booking();
        $dateTime = new \DateTime($date);

        $id = 1;
        $restaurant = $manager->getRepository(Restaurant::class)->find($id);

        $booking->setCustomer($this->getUser());
        $booking->setRestaurant($restaurant);
        $booking->setDate($dateTime);
        $booking->setNbGuests($nbGuests);

        $form = $this->createForm(BookingFormType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $booking = $form->getData();
            $manager->persist($booking);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('booking/index.html.twig', [
            'BookingFormType' => $form->createView(),
            'Restaurant' => $restaurantRepository->findAll(),
        ]);
    }
}
