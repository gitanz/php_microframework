<?php
use facades\Routes;

Routes::post('/class', 'ClassController@store');

Routes::post('/bookings', 'BookingController@book');

/*preflight*/
Routes::options('/bookings', 'BookingController@book');