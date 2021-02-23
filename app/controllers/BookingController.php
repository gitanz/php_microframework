<?php


namespace app\controllers;


use app\models\Booking;
use app\repositories\BookingsRepository;
use app\repositories\ClassRepository;
use app\requests\BookingRequest;
use system\Response;

class BookingController
{

    private BookingsRepository $bookingsRepository;
    private ClassRepository $classRepository;

    public function __construct(BookingsRepository $bookingsRepository, ClassRepository $classRepository)
    {
        $this->classRepository = $classRepository;
        $this->bookingsRepository = $bookingsRepository;
        $this->classRepository->seedClasses();
    }

    public function book(BookingRequest $request, Response $response)
    {
        $input = $request->request->getInput()->data;
        $bookingModel = new Booking();
        $bookingModel->mapParameters($input);
        $status = $this->attemptBooking($bookingModel);
        list($response_code, $status_message) = $status ?
                                                [200, "Successfully booked"] :
                                                [403, "Failed booking"];

        $response->toJson([
            "success"=> $status,
            "message" => $status_message,
            "data" => [
                "bookings" => $this->bookingsRepository->getBookings(),
                "classes" => $this->classRepository->getClasses()
            ]
            ], $response_code);

    }

    public function attemptBooking(Booking $booking)
    {
        $class = $this->classFilter($booking->date);
        $class = array_shift($class);
        $booked = false;
        // acquire lock
        if($class && $this->classRepository->acquireLock($class)){
            // book class
            $this->classRepository->bookClass($class);
            // add booking
            $this->bookingsRepository->addBooking($booking);
            //release lock
            $this->classRepository->releaseLock($class);

            $booked = true;
        }
        return $booked;
    }

    public function classFilter($bookingDate)
    {
        return array_filter($this->classRepository->getClasses(), function(&$class) use($bookingDate){
            return $class->date == $bookingDate && $class->lock == false;
        });
    }
}