<?php


namespace app\repositories;


use app\models\Booking;
use app\models\ClassModel;

class BookingsRepository
{
    public array $bookings;

    public function __construct()
    {
        $this->bookings = [];
    }

    public function addBooking(Booking $booking)
    {
        $this->bookings[] = $booking;
    }

    public function getBookings()
    {
        return $this->bookings;
    }

}