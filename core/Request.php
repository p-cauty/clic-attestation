<?php

namespace PitouFW\Core;

class Request {
	private static ?Request $instance = null;
	private array $args;
	
	private function __construct() {
		$this->args = isset($_GET['arg']) ? explode('/', $_GET['arg']) : ['home'];
        $this->args = isset($GLOBALS['argc']) ? array_slice($GLOBALS['argv'], 1) : $this->args;
	}
	
	public static function get(): Request {
		if (self::$instance == null) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	public function getArg(int $i): string {
		if (count($this->args) > $i) {
			return $this->args[$i];
		}

		return '';
	}
}
