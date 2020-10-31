<?php

use PitouFW\Core\Controller;
use PitouFW\Core\Request;
use PitouFW\Core\Router;
use PitouFW\Core\Translator;

session_start();

define('ROOT', str_replace('public/index.php', '', $_SERVER['SCRIPT_FILENAME']));
require_once ROOT . 'vendor/autoload.php';
require_once ROOT . 'config/config.php';

$bool = PROD_ENV ? 0 : 1;
$econst = PROD_ENV ? 0 : E_ALL;
ini_set('display_errors', $bool);
ini_set('display_startup_errors', $bool);
error_reporting($econst ^ E_DEPRECATED);
date_default_timezone_set('UTC');

spl_autoload_register(function ($classname) {
    $ext = '.php';
    $split = explode('\\', $classname);
    $namespace = '';
    if (count($split) > 1) {
        $last = count($split) - 1;
        $classname = $split[$last];
        unset($split[$last]);
        $namespace = implode('\\', $split);
    }

    $path = ROOT;
    if ($namespace == 'PitouFW\Model' && file_exists(MODELS.$classname.$ext)) {
        $path .= 'app/models/';
    } elseif ($namespace == 'PitouFW\Entity' && file_exists(ENTITIES.$classname.$ext)) {
        $path .= 'entities/';
    } elseif ($namespace == 'PitouFW\Core' && file_exists(CORE.$classname.$ext)) {
        $path .= 'core/';
    }

    if ($path != ROOT) {
        require_once $path . $classname . $ext;
    }
});

if (Request::get()->getArg(0) == 'api' && empty($_POST)) {
    if ($json_data = json_decode(file_get_contents('php://input'), true)) {
        $_POST = $json_data;
    }
}

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

require_once Router::get()->getPathToRequire();
