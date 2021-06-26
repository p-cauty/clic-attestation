<?php

use PitouFW\Core\Controller;
use PitouFW\Core\Data;

Data::get()->add('TITLE', NAME);
Controller::renderView('home/home');
