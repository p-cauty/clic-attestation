<?php


namespace PitouFW\Core;


class Alert {
    private static function alert(string $type, string $message): void {
        $_SESSION['alert'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    public static function success(string $message): void {
        self::alert('success', $message);
    }

    public static function warning(string $message): void {
        self::alert('warning', $message);
    }

    public static function error(string $message): void {
        self::alert('error', $message);
    }

    public static function handle(): ?string {
        if (!isset($_SESSION['alert']) || !is_array($_SESSION['alert']) || !isset($_SESSION['alert']['type'], $_SESSION['alert']['message'])) {
            return null;
        }

        $type = $_SESSION['alert']['type'];
        $theme = $type === 'error' ? 'danger' : ($type === 'warning' ? 'warning' : ($type === 'success' ? 'success' : 'info'));
        $isError = $type === 'error';
        $isWarning = $type === 'warning';
        $message = $_SESSION['alert']['message'];
        $html = '<div class="alert alert-' . $theme . ' mb-4">' . ($isError ? 'Erreur : ' : ($isWarning ? 'Attention : ' : '')) . $message . '</div>';

        unset($_SESSION['alert']);
        return $html;
    }
}
