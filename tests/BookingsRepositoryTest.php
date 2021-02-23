<?php
declare(strict_types=1);


namespace tests;


use app\models\Booking;
use app\repositories\BookingsRepository;
use PHPUnit\Framework\TestCase;
use system\DIContainer;

class BookingsRepositoryTest extends TestCase
{
    public function testAddBooking()
    {
        $booking = new Booking();
        $bookingsRepository = new BookingsRepository();
        $booking->username = "anooz";
        $booking->date = "2021-03-01";
        $bookingsRepository->addBooking($booking);
        $newBookings = $bookingsRepository->getBookings();
        $this->assertEquals(count($newBookings), 1);

    }
}