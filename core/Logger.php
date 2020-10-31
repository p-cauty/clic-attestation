<?php
/**
 * Created by PhpStorm.
 * User: Peter
 * Date: 23/05/2019
 * Time: 21:47
 */

namespace PitouFW\Core;

class Logger {
    const LOG_FILE_INFO = ROOT . 'log/info.log';
    const LOG_FILE_WARNING = ROOT . 'log/warning.log';
    const LOG_FILE_ERROR = ROOT . 'log/error.log';

    private static function log(string $message, string $filename = self::LOG_FILE_INFO, ?array $backtrace = null): void {
        if (LOGGING) {
            if (in_array($filename, [
                self::LOG_FILE_INFO,
                self::LOG_FILE_WARNING,
                self::LOG_FILE_ERROR
            ])) {
                $backtrace = $backtrace === null ? debug_backtrace() : $backtrace;
                $caller = array_shift($backtrace);
                $data = '------------------------------------------' . "\n" .
                    '[' . date('d/m/Y H:i:s') . '][' . ($_SERVER['REMOTE_ADDR'] ?? 'CLI') . ']' . "\n" .
                    '[in ' . $caller['file'] . ' line ' . $caller['line'] . ']' . "\n" .
                    $message . "\n\n";
                file_put_contents($filename, $data, FILE_APPEND);
            } else {
                self::logError('Wrong log file');
            }
        }
    }

    public static function logInfo(string $message): void {
        self::log($message, self::LOG_FILE_INFO, debug_backtrace());
    }

    public static function logWarning(string $message): void {
        self::log($message, self::LOG_FILE_WARNING, debug_backtrace());
    }

    public static function logError(string $message): void {
        self::log($message, self::LOG_FILE_ERROR, debug_backtrace());
    }
}
