<?php

namespace onebone\triggerpe;

class Variable {
	private $value;
	private $type;

	public function __construct($value, int $type){
		$this->value = $value;
		$this->type = $type;
	}

	public function getType(): int {
		return $this->type;
	}

	public function getValue(){
		return $this->value;
	}

	public function getInt(): int {
		return (int) $this->value;
	}

	public function getString(): string {
		return (string) $this->value;
	}

	public function getBool(): bool {
		return (bool) $this->value;
	}

	public static function isVariable(string $value): bool {
		return is_string($value) and strlen($value) > 1 and $value{0} === '$';
	}
}
