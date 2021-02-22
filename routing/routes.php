<?php
use facades\Routes;

Routes::get('/say/{id}/hello', 'SayController@hello');

