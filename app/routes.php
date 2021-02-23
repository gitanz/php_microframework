<?php
use facades\Routes;

Routes::post('/class', 'ClassController@store');

Routes::post('/bookings', 'BookingController@book');