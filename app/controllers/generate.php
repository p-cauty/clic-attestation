<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;
use PitouFW\Core\Request;
use PitouFW\Core\Utils;
use PitouFW\Model\CertificateModel;

$jwt = Request::get()->getArg(1);
if (!CertificateModel::isJwtValid($jwt)) {
    Alert::error('Lien invalide.');
    header('location: ' . WEBROOT);
    die;
}

Data::get()->setData(CertificateModel::parseJWT($jwt));
Data::get()->add('TITLE', 'Attestation');
Data::get()->add('is_curfew', CertificateModel::isCurfew());
Controller::renderView('home/generate');
