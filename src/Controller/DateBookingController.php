<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Form\DateBookingFormType;
use App\Entity\Booking;
use App\Entity\Restaurant;
use App\Entity\Customer;
use App\Repository\RestaurantRepository;

use Doctrine\ORM\EntityManagerInterface;

class DateBookingController extends AbstractController
{
    #[Route('/bookingDate', name: 'booking')]
    public function index(Request $request, EntityManagerInterface $manager, RestaurantRepository $restaurantRepository)
    {
        $formDate = $this->createForm(DateBookingFormType::class);
        $formDate->handleRequest($request);
        
        $date = new \DateTimeImmutable();
        $nbGuests = 1;

        $remainingPlacesLunch = 0;
        $remainingPlacesDinner = 0;
        $rush = '';
        
        $selectDate = false;
        $validDate = false;

        if ($this->getUser()){
            $nbGuests = $manager->getRepository(Customer::class)->find($this->getUser())->getNbGuests();
        }

        if ($formDate->isSubmitted() && $formDate->isValid()) {

            $hour = substr($formDate->getData()['hour'], 0, 2);
            $minute = substr($formDate->getData()['hour'], 3, 2);
            $date = $formDate->getData()['date']->setTime($hour, $minute);
            $nbGuests = $formDate->getData()['nbGuests'];

            $startLunchRush = $date->setTime(12, 0);
            $endLunchRush = $date->setTime(14, 0);
            $bookingsLunch = $manager->getRepository(Booking::class)->findByRush($startLunchRush, $endLunchRush);
            $totalGuestsLunch = array_reduce($bookingsLunch, function ($previous, $booking) {
                return $previous + $booking->getNbGuests();
            }, 0);

            $startDinnerRush = $date->setTime(19, 0);
            $endDinnerRush = $date->setTime(21, 0);
            $bookingsDinner = $manager->getRepository(Booking::class)->findByRush($startDinnerRush, $endDinnerRush);
            $totalGuestsDinner = array_reduce($bookingsDinner, function ($previous, $booking) {
                return $previous + $booking->getNbGuests();
            }, 0);

            $seatingCapacity = $manager->getRepository(Restaurant::class)->findById(1)[0]->getSeatingCapacity();
            $remainingPlacesLunch = $seatingCapacity - $totalGuestsLunch;
            $remainingPlacesDinner = $seatingCapacity - $totalGuestsDinner;

            if ($hour === '12' || $hour === '13') {
                $rush = 'lunch';
            } else if ($hour === '19' || $hour === '20') {
                $rush = 'dinner';
            }

            if ((($rush === 'lunch') && ($nbGuests <= $remainingPlacesLunch)) || (($rush === 'dinner') && ($nbGuests <= $remainingPlacesDinner))) {
                $validDate = true;
            }

            $selectDate = true;
        }

        return $this->render('date_booking/index.html.twig', [
            'DateBookingFormType' => $formDate->createView(),
            'date' => $date->format('d-m-Y H:i:s'),
            'nbGuests' => $nbGuests,
            'remainingPlacesLunch' => $remainingPlacesLunch,
            'remainingPlacesDinner' => $remainingPlacesDinner,
            'selectDate' => $selectDate,
            'validDate' => $validDate,
            'Restaurant' => $restaurantRepository->findAll(),
        ]);
    }
}
