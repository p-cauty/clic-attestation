<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Request;
use \PitouFW\Entity\Citizen;
use \PitouFW\Entity\Certificate;
use PitouFW\Model\CertificateModel;

$jwt = Request::get()->getArg(1);
if (!CertificateModel::isJwtValid($jwt)) {
    Alert::error('Lien invalide.');
    header('location: ' . WEBROOT);
    die;
}

$data = CertificateModel::parseJWT($jwt);

$citizen = new Citizen();
$citizen->setFirstname($data['firstname'])
    ->setLastname($data['lastname'])
    ->setBirthDate($data['birth_date'])
    ->setBirthLocation($data['birth_location'])
    ->setStreetAddress($data['street_address']);

$certificate = new Certificate();
$certificate->setCitizen($citizen)
    ->setReason($_GET['reason'] ?? '')
    ->setMadeIn($_GET['made_in'] ?? $data['made_in'])
    ->generate();

CertificateModel::count();

switch ($_GET['output'] ?? '') {
    /*case 'save':
        $certificate->save();
        die('<a href="./upload/' . $certificate->getFilename() . '">Voir le fichier</a>');*/

    case 'download':
        $certificate->download();
        break;

    default:
        $certificate->show();
}
