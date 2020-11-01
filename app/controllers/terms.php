<?php

use PitouFW\Core\Controller;
use PitouFW\Core\Data;

Data::get()->add('TITLE', 'Mentions légales - ' . NAME);
Controller::renderView('home/terms');
