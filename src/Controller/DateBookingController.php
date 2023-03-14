<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Form\DateBookingFormType;
use App\Entity\Booking;
use App\Entity\Restaurant;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class DateBookingController extends AbstractController
{
    #[Route('/bookingDate', name: 'booking')]
    public function index(Request $request, EntityManagerInterface $manager, UserInterface $user)
    {
        $date = new \DateTimeImmutable();

        $formDate = $this->createForm(DateBookingFormType::class);
        $formDate->handleRequest($request);

        $nbGuests = 1;

        if ($this->getUser()){
            $indentifier = $user->getUserIdentifier();
            $customer = $manager->getRepository(Customer::class)->findByEmail($indentifier);
            $nbGuests = $customer[0]->getNbGuests();
        }
        
        $selectDate = false;
        $validDate = false;
        $remainingPlacesLunch = 0;
        $remainingPlacesDinner = 0;
        $rush = '';

        if ($formDate->isSubmitted() && $formDate->isValid()) {

            $hour = $formDate->getData()['hour'];
            $minute = $formDate->getData()['minutes'];
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

            if ($hour === 12 || $hour === 13) {
                $rush = 'lunch';
            } else if ($hour === 19 || $hour === 20) {
                $rush = 'dinner';
            }

            if ((($rush === 'lunch') && ($nbGuests <= $remainingPlacesLunch)) || (($rush === 'dinner') && ($nbGuests <= $remainingPlacesDinner))) {
                $validDate = true;
            }

            $selectDate = true;
        }

        return $this->render('date_booking/index.html.twig', [
            'DateBookingFormType' => $formDate->createView(),
            'selectDate' => $selectDate,
            'validDate' => $validDate,
            'remainingPlacesLunch' => $remainingPlacesLunch,
            'remainingPlacesDinner' => $remainingPlacesDinner,
            'date' => $date->format('d-m-Y H:i:s'),
            'nbGuests' => $nbGuests,
        ]);
    }
}
