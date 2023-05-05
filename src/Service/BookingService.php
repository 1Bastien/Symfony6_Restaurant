<?php

namespace App\Service;

use App\Enum\RushType;
use App\Repository\BookingRepository;
use App\Repository\RestaurantRepository;

class BookingService
{
    private BookingRepository $bookingRepository;

    private RestaurantRepository $restaurantRepository;

    public function __construct(BookingRepository $bookingRepository, RestaurantRepository $restaurantRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->restaurantRepository = $restaurantRepository;
    }

    public function getRemainingPlaces(RushType $rushType): int
    {
        $bookingsRush = $this->bookingRepository->findByRush($rushType->getStart(), $rushType->getEnd());

        $totalGuestsBook = array_reduce($bookingsRush, function ($previous, $booking) {
            return $previous + $booking->getNbGuests();
        }, 0);

        $seatingCapacity = $this->restaurantRepository->findById(1)[0]->getSeatingCapacity();

        return $seatingCapacity - $totalGuestsBook;
    }

    public function isBookingPossible(int $nbGuests, int $remainingPlaces): bool 
    {
        return $nbGuests <= $remainingPlaces;
    }
}
