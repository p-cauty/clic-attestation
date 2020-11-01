<?php

namespace PitouFW\Core;

abstract class Controller {
    public static function __callStatic(string $name, array $arguments): void {
        if (substr($name, 0, 4) == 'http') {
            $errCode = substr($name, 4, 3);
            $errMsg = preg_replace("#([A-Z])#", " $1", substr($name, 7));
            header("HTTP/1.1 $errCode$errMsg");
            if (Request::get()->getArg(0) !== 'api') {
                if (file_exists(VIEWS . 'error/' . $errCode . '.php')) {
                    self::renderView('error/' . $errCode);
                    die;
                } else {
                    die($errCode);
                }
            } else {
                self::renderApiError(trim($errMsg));
            }
        }
    }

    public static function renderView(string $path, ?string $layout = 'mainView.php'): void {
        if (!is_null($layout)) {
            $layout = file_exists(VIEWS . $layout) ? VIEWS . $layout : VIEWS . 'mainView.php';
        }

        $file = VIEWS.$path.'.php';
        if (file_exists($file) ) {
            $appView = $file;
            $dataToExtract = Request::get()->getArg(0) !== 'api' ? Utils::secure(Data::get()->getData()) : Data::get()->getData();
            extract($dataToExtract);
            if (!is_null($layout)) {
                require_once $layout;
            }
            else {
                require_once $appView;
            }
        }
        else {
            self::http500InternalServerError();
        }
    }

    public static function renderApiError(string $message): void {
        Logger::logError($message);
        Data::get()->add('status', 'error');
        Data::get()->add('message', $message);
        Controller::renderView('json/json', null);
        die;
    }

    public static function renderApiSuccess(): void {
        Data::get()->setData(['status' => 'success', 'data' => Data::get()->getData()]);
        Controller::renderView('json/json', null);
        die;
    }

    public static function sendNoCacheHeaders(): void {
        header('Cache-Control: no-store');
        header('Pragma: no-cache');
    }
}
