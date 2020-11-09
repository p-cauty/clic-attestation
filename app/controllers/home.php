<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Controller;
use PitouFW\Core\Data;

if (POST) {
    if (
        !empty($_POST['firstname']) &&
        !empty($_POST['lastname']) &&
        !empty($_POST['birth_date']) &&
        !empty($_POST['birth_location']) &&
        !empty($_POST['street_address']) &&
        !empty($_POST['postal_code']) &&
        !empty($_POST['city'])
    ) {
        $payload = base64_encode(
            json_encode([
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'birth_date' => $_POST['birth_date'],
                'birth_location' => $_POST['birth_location'],
                'street_address' => $_POST['street_address'] . ' ' . $_POST['postal_code'] . ' ' . $_POST['city'],
                'made_in' => $_POST['city']
            ])
        );
        $signature = base64_encode(hash_hmac('sha256', $payload, JWT_KEY));
        $jwt = $payload . '.' . $signature;

        setcookie('jwt', $jwt, time()+60*60*24*365, '/');

        Alert::success('Bienvenue sur votre générateur personnel d\'attestation !');
        header('location: ' . WEBROOT . 'generate/' . $jwt);
        die;
    } else {
        Alert::error('Merci de renseigner tous les champs.');
    }
}

Data::get()->add('TITLE', NAME);
Controller::renderView('home/home');
