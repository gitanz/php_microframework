<?php
use facades\Routes;

Routes::post('/say/{id}/hello', 'SayController@hello');

