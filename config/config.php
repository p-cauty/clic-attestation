<?php

require_once __DIR__ . '/app.php';

if (file_exists(__DIR__ . '/host.dist.php')) {
    require_once __DIR__ . '/host.dist.php';
} else {
    require_once __DIR__ . '/host.dev.php';
}


const PROD_ENV = ENV_NAME === 'prod';

define('POST', !isset($argc) && $_SERVER['REQUEST_METHOD'] === 'POST');
define('WEBROOT', !isset($argc) ? str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) : '');

const ENTITIES = ROOT . 'entities/';
const CORE = ROOT . 'core/';
const APP = ROOT . 'app/';
const MODELS = APP . 'models/';
const VIEWS = APP . 'views/';
const CONTROLLERS = APP . 'controllers/';
const ASSETS = WEBROOT . 'assets/';
const CSS = ASSETS . 'css/';
const JS = ASSETS . 'js/';
const IMG = ASSETS . 'img/';
const VENDORS = ASSETS . 'vendors/';
