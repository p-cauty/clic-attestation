<?php


namespace PitouFW\Model;


class CertificateModel {
    const ATTEST_COUNT_FILE = ROOT . 'attest.txt';

    public static function isJwtValid(string $jwt): bool {
        if ($jwt === '') {
            return false;
        }

        $pieces = explode('.', $jwt);
        return base64_decode($pieces[1]) === hash_hmac('sha256', $pieces[0], JWT_KEY) ||
            base64_decode($pieces[1]) === hash_hmac('sha256', $pieces[0], JWT_KEY_1);
    }

    public static function parseJWT(string $jwt): ?array {
        $pieces = explode('.', $jwt);
        return json_decode(base64_decode($pieces[0]), true);
    }

    public static function handleUTF8(string $str): string {
        return iconv('UTF-8', 'windows-1252', $str);
    }

    public static function count(): void {
        $count = (int) file_get_contents(self::ATTEST_COUNT_FILE);
        $count++;
        file_put_contents(self::ATTEST_COUNT_FILE, $count);
    }
}
