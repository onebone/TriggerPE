<?php

namespace onebone\triggerpe;

class Variable {
	const TYPE_VOID = 0;
	const TYPE_INT = 1;
	const TYPE_BOOL = 2;
	const TYPE_STRING = 3;

	private $value;
	private $type;

	public function __construct($value, $type){
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
