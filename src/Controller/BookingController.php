<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\BookingFormType;
use App\Entity\Booking;
use App\Enum\RushType;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Service\BookingService;

class BookingController extends AbstractController
{
    #[Route('/booking/{date}/{nbGuests}', name: 'booking_customer')]
    public function bookingCustomer(int $nbGuests, string $date, Request $request, EntityManagerInterface $manager, RestaurantRepository $restaurantRepository, BookingService $bookingService): Response
    {
        $dateTime = new \DateTimeImmutable($date);

        $remainingPlaces = $bookingService->getRemainingPlaces(RushType::fromDateTime($dateTime));
        if (!$bookingService->isBookingPossible($nbGuests, $remainingPlaces)) {
            return $this->redirectToRoute('home');
        }
        
        $booking = new Booking();
        $booking
            ->setCustomer($this->getUser())
            ->setRestaurant($restaurantRepository->findById(1)[0])
            ->setDate($dateTime)
            ->setNbGuests($nbGuests);

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
