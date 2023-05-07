<?php

namespace App\Controller;

use App\Form\DateBookingFormType;
use App\Enum\RushType;
use App\Repository\CustomerRepository;
use App\Repository\RestaurantRepository;
use App\Service\BookingService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class DateBookingController extends AbstractController
{
    #[Route('/bookingDate', name: 'booking')]
    public function index(Request $request, CustomerRepository $customerRepository, RestaurantRepository $restaurantRepository, BookingService $bookingService)
    {
        $date = new \DateTimeImmutable();
        
        $selectDate = false;
        $validDate = false;
        
        $nbGuests = 1;
        if ($this->getUser()) {
            $nbGuests = $customerRepository->find($this->getUser())->getNbGuests();
        }

        $formDate = $this->createForm(DateBookingFormType::class);
        $formDate->handleRequest($request);

        if ($formDate->isSubmitted() && $formDate->isValid()) {

            $hour = substr($formDate->getData()['hour'], 0, 2);
            $minute = substr($formDate->getData()['hour'], 3, 2);
            $date = $formDate->getData()['date']->setTime($hour, $minute);
            $nbGuests = $formDate->getData()['nbGuests'];
    
            $selectDate = true;

            $remainingPlaces = $bookingService->getRemainingPlaces(RushType::fromHour($hour), $date);

            $validDate = $bookingService->isBookingPossible($nbGuests, $remainingPlaces);
        }

        return $this->render('date_booking/index.html.twig', [
            'DateBookingFormType' => $formDate->createView(),

            'date' => $date->format('d-m-Y H:i:s'),
            'nbGuests' => $nbGuests,

            'remainingPlacesLunch' => $bookingService->getRemainingPlaces(RushType::LUNCH, $date),
            'remainingPlacesDinner' => $bookingService->getRemainingPlaces(RushType::DINNER, $date),

            'selectDate' => $selectDate,
            'validDate' => $validDate,

            'Restaurant' => $restaurantRepository->findAll(),
        ]);
    }
}
