<?php

use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Model\CertificateModel;

Data::get()->add('count', CertificateModel::getCount());
Controller::renderApiSuccess();
