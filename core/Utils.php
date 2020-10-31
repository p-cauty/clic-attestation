<?php

namespace PitouFW\Core;

use ReflectionClass;
use ReflectionProperty;

class Utils {
	public static function time(): int {
		return time() + (3600 * JET_LAG);
	}

	public static function fromSnakeCaseToCamelCase(string $string): string {
		return preg_replace_callback("#_([a-z0-9])#", function (array $matches): string {
			return strtoupper($matches[1]);
		}, ucfirst($string));
	}

	public static function secure($data) {
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$data[$k] = self::secure($data[$k]);
			}
			return $data;
		}
		elseif (is_object($data)) {
			foreach ($data as $k => $v) {
				$data->$k = self::secure($data->$k);
			}
			$classname = get_class($data);
			$ref = new ReflectionClass($classname);
			$props = $ref->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED);
			foreach ($props as $prop) {
				$getter = 'get'.self::fromSnakeCaseToCamelCase($prop->getName());
				$setter = 'set'.self::fromSnakeCaseToCamelCase($prop->getName());
				if (method_exists($data, $getter) && method_exists($data, $setter)) {
					$data->$setter(self::secure($data->$getter()));
				}
			}
			return $data;
		}
		elseif (!is_string($data)) {
			return $data;
		}
		else {
			$data = htmlentities($data);
			return $data;
		}
	}

    public static function str2hex(string $string): string {
        $hex = '';
        for ($i=0; $i<strlen($string); $i++){
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0'.$hexCode, -2);
        }
        return $hex;
    }

    public static function hex2str(string $hex): string {
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2){
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }

    public static function slugify(string $string, string $delimiter = '-') {
        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        $clean = strtr(utf8_decode($string), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $clean);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower($clean);
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = trim($clean, $delimiter);
        setlocale(LC_ALL, $oldLocale);
        return $clean;
    }

    public static function isInternalCall() {
        return isset($_SERVER['HTTP_X_ACCESS_TOKEN']) && $_SERVER['HTTP_X_ACCESS_TOKEN'] === INTERNAL_API_KEY;
    }

    public static function expandIPV6(string $ip): string {
        $is_ipv6 = strpos($ip, ':') !== false;
        if (!$is_ipv6) {
            return $ip;
        }

        $hex = bin2hex(inet_pton($ip));
        return implode(':', str_split($hex, 4));
    }

    public static function truncateIPV6(string $ip, int $blocksCnt): string {
        $is_ipv6 = strpos($ip, ':') !== false;
        if (!$is_ipv6) {
            return $ip;
        }

        $full_length_ip = self::expandIPV6($ip);
        $blocks = explode(':', $full_length_ip);
        return implode(':', array_slice($blocks, 0, count($blocks) - $blocksCnt));
    }

    public static function slugifyIp(string $ip): string {
        $is_ipv6 = strpos($ip, ':') !== false;
        return $is_ipv6 ?
            str_replace(':', '_', $ip) :
            str_replace('.', '_', $ip);
    }

    public static function parseIpForAntispam(string $ip): string {
        return self::slugifyIp(self::truncateIPV6($ip, 4));
    }

    public static function generateToken(int $length = 64): ?string {
        if ($length % 4 !== 0) {
            return null;
        }

        $bytes_number = 0.75 * $length;
        return str_replace('+', '', str_replace('/', '', base64_encode(openssl_random_pseudo_bytes($bytes_number))));
    }

    public static function datetime(?int $time = null): string {
        return date('Y-m-d H:i:s', $time === null ? self::time() : $time);
    }
}
